<?php
declare(strict_types=1);
include 'db.php';
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Self-healing table creation
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `tolly_cron_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cron_expression` varchar(100) DEFAULT '0 7 */7 * *',
  `is_active` tinyint(1) DEFAULT 1,
  `last_run` datetime DEFAULT NULL,
  `next_run` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

// Seed default row if empty
$resSeed = mysqli_query($conn, "SELECT COUNT(*) FROM `tolly_cron_config`");
$rowSeed = mysqli_fetch_row($resSeed);
if ($rowSeed && $rowSeed[0] == 0) {
    mysqli_query($conn, "INSERT INTO `tolly_cron_config` (`cron_expression`, `is_active`) VALUES ('0 7 */7 * *', 1)");
}

require_once 'cron_helper.php';

// Fetch cron config
$cronRes = mysqli_query($conn, "SELECT * FROM `tolly_cron_config` WHERE `id` = 1");
$cronConfig = mysqli_fetch_assoc($cronRes);

if (!$cronConfig || (int)$cronConfig['is_active'] === 0) {
    die("Cron scheduler is inactive or not configured.");
}

$now = time();
$nextRunTimestamp = $cronConfig['next_run'] ? strtotime($cronConfig['next_run']) : null;

// Calculate next run if it's not set
if ($nextRunTimestamp === null) {
    try {
        $nextRun = CronParser::getNextRunDate($cronConfig['cron_expression'], $now);
        $nextRunStr = date('Y-m-d H:i:s', $nextRun);
        mysqli_query($conn, "UPDATE `tolly_cron_config` SET `next_run` = '{$nextRunStr}' WHERE `id` = 1");
        echo "Initialized next scheduled run: {$nextRunStr}\n";
    } catch (Exception $e) {
        die("Error setting initial run: " . $e->getMessage());
    }
    exit;
}

if ($now < $nextRunTimestamp) {
    die("Next run is scheduled for: " . $cronConfig['next_run'] . " (Current time is: " . date('Y-m-d H:i:s', $now) . ")");
}

// It is time to run the backup!
$backupsDir = __DIR__ . '/backups';
if (!is_dir($backupsDir)) {
    @mkdir($backupsDir, 0755, true);
}

// Include Mailer Helpers
require_once 'smtp_helper.php';

// Fetch Email Settings
$emailConfigRes = mysqli_query($conn, "SELECT * FROM `tolly_email_config` WHERE `id` = 1");
$emailConfig = mysqli_fetch_assoc($emailConfigRes);

$recipientString = $emailConfig['recipient_emails'] ?? '';
$fromEmail = $emailConfig['from_email'] ?? 'backup@hitandfut.com';
$fromName = $emailConfig['from_name'] ?? 'HitandFut Backup';

$emails = preg_split('/[\s,;]+/', $recipientString);
$validEmails = [];
foreach ($emails as $email) {
    $email = trim($email);
    if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $validEmails[] = $email;
    }
}

$dbName = $dbname;
$logMsg = "";

try {
    // 1. Run the backup
    $logMsg .= "[" . date('Y-m-d H:i:s') . "] Starting automated backup...\n";
    
    // Synchronous Backup Function
    $backupFile = runBackup($conn, $backupsDir, $dbName);
    
    $logMsg .= "[" . date('Y-m-d H:i:s') . "] Backup completed successfully: {$backupFile}\n";
    
    // 2. Dispatch Success Email
    if (!empty($validEmails)) {
        $logMsg .= "[" . date('Y-m-d H:i:s') . "] Dispatching backup file to recipient(s)...\n";
        MailSender::send(
            $emailConfig,
            $fromEmail,
            $fromName,
            $validEmails,
            "SUCCESS: Automated Database Backup - " . date('j-F-Y'),
            "<h3>Automated Backup Success</h3>
             <p>The automated backup scheduled job was triggered successfully.</p>
             <p><b>Backup Details:</b></p>
             <ul>
                <li>Database: {$dbName}</li>
                <li>File: {$backupFile}</li>
                <li>Trigger Time: " . date('Y-m-d H:i:s', $now) . "</li>
             </ul>
             <pre><b>Execution Logs:</b>\n" . htmlspecialchars($logMsg) . "</pre>",
            $backupsDir . '/' . $backupFile,
            $backupFile
        );
        $logMsg .= "[" . date('Y-m-d H:i:s') . "] Backup email delivered successfully.\n";
    } else {
        $logMsg .= "[" . date('Y-m-d H:i:s') . "] Warning: No recipient email configured.\n";
    }

} catch (Exception $e) {
    $errorMsg = $e->getMessage();
    $logMsg .= "[" . date('Y-m-d H:i:s') . "] CRITICAL ERROR: " . $errorMsg . "\n";
    
    // Dispatch Failure Email
    if (!empty($validEmails)) {
        try {
            MailSender::send(
                $emailConfig,
                $fromEmail,
                $fromName,
                $validEmails,
                "FAILED: Automated Database Backup - " . date('j-F-Y'),
                "<h3>Automated Backup Failed</h3>
                 <p>The automated database backup job encountered an error during execution.</p>
                 <p><b>Error:</b> " . htmlspecialchars($errorMsg) . "</p>
                 <pre><b>Execution Logs:</b>\n" . htmlspecialchars($logMsg) . "</pre>"
            );
        } catch (Exception $mailEx) {
            // Log local error
            error_log("Failed to send failure notification email: " . $mailEx->getMessage());
        }
    }
    echo "Backup failed: " . $errorMsg . "\n";
}

// Calculate the new next_run time starting from now
$newNextRunStr = null;
try {
    $newNextRun = CronParser::getNextRunDate($cronConfig['cron_expression'], time());
    $newNextRunStr = date('Y-m-d H:i:s', $newNextRun);
} catch (Exception $cronEx) {
    error_log("Failed to calculate next run date: " . $cronEx->getMessage());
}

$lastRunStr = date('Y-m-d H:i:s', $now);
$updateQuery = "UPDATE `tolly_cron_config` SET `last_run` = '{$lastRunStr}'";
if ($newNextRunStr) {
    $updateQuery .= ", `next_run` = '{$newNextRunStr}'";
}
$updateQuery .= " WHERE `id` = 1";

mysqli_query($conn, $updateQuery);

echo "Automated cron run finished. Logs:\n" . $logMsg;


function runBackup($conn, string $backupsDir, string $db): string {
    $tables = [];
    $res = @mysqli_query($conn, 'SHOW TABLES');
    if (!$res) {
        throw new Exception('Failed to list tables: ' . @mysqli_error($conn));
    }
    while ($row = mysqli_fetch_row($res)) {
        $tables[] = $row[0];
    }

    $sessionFile = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
    $filepath = $backupsDir . '/' . $sessionFile;
    
    $fp = @fopen($filepath, 'w');
    if (!$fp) {
        throw new Exception('Cannot create backup file in backups/ directory');
    }
    fwrite($fp, "-- HitandFut Database Backup\n");
    fwrite($fp, "-- Date: " . date('Y-m-d H:i:s') . "\n");
    fwrite($fp, "-- Database: {$db}\n\n");
    fclose($fp);

    $limitedTables = [
        'tolly_news' => 'nid',
        'tolly_s1' => 'sid',
        'tolly_s2' => 'sid',
        'tolly_s3' => 'sid',
        'tolly_s4' => 'sid',
        'tolly_s5' => 'sid',
        'tolly_s6' => 'sid',
        'tolly_s7' => 'sid',
        'tolly_s8' => 'sid',
        'tolly_s9' => 'sid'
    ];

    foreach ($tables as $table) {
        $createRes = @mysqli_query($conn, 'SHOW CREATE TABLE `' . $table . '`');
        if (!$createRes) {
            throw new Exception("Failed to read structure for table: {$table} - " . @mysqli_error($conn));
        }
        $createRow = mysqli_fetch_row($createRes);

        if (isset($limitedTables[$table])) {
            $orderBy = $limitedTables[$table];
            $query = "SELECT * FROM `{$table}` ORDER BY `{$orderBy}` DESC LIMIT 20";
        } else {
            $query = "SELECT * FROM `{$table}`";
        }

        $dataRes = @mysqli_query($conn, $query);
        if (!$dataRes) {
            throw new Exception("Failed to read data from table: {$table} - " . @mysqli_error($conn));
        }
        $numFields = mysqli_num_fields($dataRes);
        
        $rowsData = [];
        while ($row = mysqli_fetch_row($dataRes)) {
            $rowsData[] = $row;
        }

        if (isset($limitedTables[$table])) {
            $rowsData = array_reverse($rowsData);
        }
        $numRows = count($rowsData);

        $fp = @fopen($filepath, 'a');
        if (!$fp) {
            throw new Exception("Cannot write to backup file");
        }
        fwrite($fp, "DROP TABLE IF EXISTS `{$table}`;\n");
        fwrite($fp, $createRow[1] . ";\n\n");

        if ($numRows > 0) {
            $counter = 1;
            foreach ($rowsData as $row) {
                if ($counter === 1) {
                    fwrite($fp, "INSERT INTO `{$table}` VALUES(");
                } else {
                    fwrite($fp, "(");
                }
                for ($j = 0; $j < $numFields; $j++) {
                    $val = $row[$j];
                    if ($val === null) {
                        fwrite($fp, 'NULL');
                    } else {
                        $val = addslashes((string)$val);
                        fwrite($fp, '"' . $val . '"');
                    }
                    if ($j < $numFields - 1) {
                        fwrite($fp, ',');
                    }
                }
                fwrite($fp, ($numRows === $counter) ? ");\n" : "),\n");
                $counter++;
            }
        }
        fwrite($fp, "\n");
        fclose($fp);
    }

    $files = glob($backupsDir . '/backup_*.sql');
    if ($files !== false && count($files) > 5) {
        usort($files, fn($a, $b) => filemtime($b) - filemtime($a));
        for ($i = 5; $i < count($files); $i++) {
            @unlink($files[$i]);
        }
    }

    return $sessionFile;
}
?>
