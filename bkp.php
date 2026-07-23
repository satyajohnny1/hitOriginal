<?php
declare(strict_types=1);
include 'sessionCheck.php';
include 'db.php';
error_reporting(E_ERROR);

// Self-healing table creation
$checkCol = mysqli_query($conn, "SHOW COLUMNS FROM `tolly_email_config` LIKE 'email_provider'");
if ($checkCol && mysqli_num_rows($checkCol) == 0) {
    mysqli_query($conn, "DROP TABLE IF EXISTS `tolly_email_config`");
}

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `tolly_email_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_provider` varchar(50) DEFAULT 'smtp',
  `mailersend_api_token` text DEFAULT NULL,
  `smtp_host` varchar(250) DEFAULT NULL,
  `smtp_port` int(11) DEFAULT 587,
  `smtp_username` varchar(250) DEFAULT NULL,
  `smtp_password` text DEFAULT NULL,
  `smtp_secure` varchar(50) DEFAULT 'tls',
  `from_email` varchar(250) DEFAULT NULL,
  `from_name` varchar(250) DEFAULT NULL,
  `recipient_emails` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

// Seed default row if empty
$resSeed = mysqli_query($conn, "SELECT COUNT(*) FROM `tolly_email_config`");
$rowSeed = mysqli_fetch_row($resSeed);
if ($rowSeed && $rowSeed[0] == 0) {
    mysqli_query($conn, "INSERT INTO `tolly_email_config` (`email_provider`, `mailersend_api_token`, `smtp_host`, `smtp_port`, `smtp_username`, `smtp_password`, `smtp_secure`, `from_email`, `from_name`, `recipient_emails`) 
                         VALUES ('smtp', '', 'smtp.mailersend.net', 587, '', '', 'tls', 'backup@hitandfut.com', 'HitandFut Backup', '')");
}

// Fetch preconfigured emails
$emailConfigRes = mysqli_query($conn, "SELECT `recipient_emails` FROM `tolly_email_config` WHERE `id` = 1");
$emailConfig = mysqli_fetch_assoc($emailConfigRes) ?: ['recipient_emails' => ''];
$preconfiguredEmails = $emailConfig['recipient_emails'] ?? '';

// Self-healing cron table creation
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `tolly_cron_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cron_expression` varchar(100) DEFAULT '0 7 */7 * *',
  `is_active` tinyint(1) DEFAULT 1,
  `last_run` datetime DEFAULT NULL,
  `next_run` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

// Seed default row if empty
$resSeedCron = mysqli_query($conn, "SELECT COUNT(*) FROM `tolly_cron_config`");
$rowSeedCron = mysqli_fetch_row($resSeedCron);
if ($rowSeedCron && $rowSeedCron[0] == 0) {
    mysqli_query($conn, "INSERT INTO `tolly_cron_config` (`cron_expression`, `is_active`) VALUES ('0 7 */7 * *', 1)");
}

// Fetch cron config
$cronConfigRes = mysqli_query($conn, "SELECT * FROM `tolly_cron_config` WHERE `id` = 1");
$cronConfig = mysqli_fetch_assoc($cronConfigRes) ?: [
    'cron_expression' => '0 7 */7 * *',
    'is_active' => 0,
    'last_run' => null,
    'next_run' => null
];


$backupsDir = __DIR__ . '/backups';
if (!is_dir($backupsDir)) {
    @mkdir($backupsDir, 0755, true);
}

$host = $servername;
$db   = $dbname;
$user = $username;
$pass = $password;
$port = '3306';

$backups = [];
foreach (glob($backupsDir . '/backup_*.sql') as $file) {
    $backups[] = [
        'name' => basename($file),
        'size' => filesize($file),
        'time' => filemtime($file),
    ];
}
usort($backups, fn($a, $b) => $b['time'] - $a['time']);
$backups = array_slice($backups, 0, 5);

if (isset($_GET['action'])) {
    header('Content-Type: application/json');

    if ($_GET['action'] === 'save_cron') {
        $cronExpr = trim($_POST['cron_expression'] ?? '');
        if (empty($cronExpr)) {
            echo json_encode(['success' => false, 'error' => 'Cron expression cannot be empty']);
            exit;
        }

        $fields = explode(' ', $cronExpr);
        if (count($fields) !== 5) {
            echo json_encode(['success' => false, 'error' => 'Invalid cron format. Must contain exactly 5 space-separated fields.']);
            exit;
        }

        require_once 'cron_helper.php';
        try {
            $nextRun = CronParser::getNextRunDate($cronExpr, time());
            $nextRunStr = date('Y-m-d H:i:s', $nextRun);
            
            $stmt = mysqli_prepare($conn, "UPDATE `tolly_cron_config` SET `cron_expression` = ?, `is_active` = 1, `next_run` = ? WHERE `id` = 1");
            mysqli_stmt_bind_param($stmt, "ss", $cronExpr, $nextRunStr);
            if (mysqli_stmt_execute($stmt)) {
                echo json_encode(['success' => true, 'message' => 'Backup scheduled successfully. Next run: ' . $nextRunStr, 'next_run' => $nextRunStr]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Database error: ' . mysqli_stmt_error($stmt)]);
            }
            mysqli_stmt_close($stmt);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => 'Error: ' . $e->getMessage()]);
        }
        exit;
    }

    if ($_GET['action'] === 'delete_cron') {
        $stmt = mysqli_prepare($conn, "UPDATE `tolly_cron_config` SET `is_active` = 0, `next_run` = NULL WHERE `id` = 1");
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true, 'message' => 'Schedule deactivated/deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Database error: ' . mysqli_stmt_error($stmt)]);
        }
        mysqli_stmt_close($stmt);
        exit;
    }

    if ($_GET['action'] === 'get_tables') {
        $tables = [];
        $res = @mysqli_query($conn, 'SHOW TABLES');
        if (!$res) {
            echo json_encode(['success' => false, 'error' => 'Failed to list tables: ' . @mysqli_error($conn)]);
            exit;
        }
        while ($row = mysqli_fetch_row($res)) {
            $tables[] = $row[0];
        }
        $sessionFile = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        $_SESSION['backup_file'] = $sessionFile;
        $_SESSION['backup_tables'] = $tables;
        $_SESSION['backup_index'] = 0;

        $fp = @fopen($backupsDir . '/' . $sessionFile, 'w');
        if (!$fp) {
            echo json_encode(['success' => false, 'error' => 'Cannot create backup file in backups/ directory']);
            exit;
        }
        fwrite($fp, "-- HitandFut Database Backup\n");
        fwrite($fp, "-- Date: " . date('Y-m-d H:i:s') . "\n");
        fwrite($fp, "-- Database: {$db}\n\n");
        fclose($fp);

        echo json_encode([
            'success' => true,
            'tables' => $tables,
            'total' => count($tables),
        ]);
        exit;
    }

    if ($_GET['action'] === 'backup_table') {
        $tables = $_SESSION['backup_tables'] ?? [];
        $index  = (int)($_SESSION['backup_index'] ?? 0);
        $file   = $_SESSION['backup_file'] ?? '';

        if ($index >= count($tables)) {
            echo json_encode(['success' => false, 'error' => 'No more tables to backup']);
            exit;
        }

        $table = $tables[$index];
        $filepath = $backupsDir . '/' . $file;
        $rows = 0;

        try {
            $createRes = @mysqli_query($conn, 'SHOW CREATE TABLE `' . $table . '`');
            if (!$createRes) {
                throw new Exception("Failed to read structure for table: {$table} - " . @mysqli_error($conn));
            }
            $createRow = mysqli_fetch_row($createRes);

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

            $counter = 1;
            foreach ($rowsData as $row) {
                if ($counter === 1) {
                    fwrite($fp, "INSERT INTO `{$table}` VALUES(");
                } else {
                    fwrite($fp, "(");
                }
                for ($j = 0; $j < $numFields; $j++) {
                    $row[$j] = addslashes((string)$row[$j]);
                    fwrite($fp, '"' . $row[$j] . '"');
                    if ($j < $numFields - 1) {
                        fwrite($fp, ',');
                    }
                }
                fwrite($fp, ($numRows === $counter) ? ");\n" : "),\n");
                $counter++;
                $rows++;
            }
            fwrite($fp, "\n\n");
            fclose($fp);

            $index++;
            $_SESSION['backup_index'] = $index;

            echo json_encode([
                'success'   => true,
                'table'     => $table,
                'rows'      => $rows,
                'current'   => $index,
                'total'     => count($tables),
                'remaining' => count($tables) - $index,
            ]);
        } catch (Exception $e) {
            @unlink($filepath);
            unset($_SESSION['backup_file'], $_SESSION['backup_tables'], $_SESSION['backup_index']);
            echo json_encode([
                'success' => false,
                'error'   => $e->getMessage(),
                'table'   => $table,
            ]);
        }
        exit;
    }

    if ($_GET['action'] === 'finalize') {
        $file = $_SESSION['backup_file'] ?? '';
        $filepath = $backupsDir . '/' . $file;
        unset($_SESSION['backup_file'], $_SESSION['backup_tables'], $_SESSION['backup_index']);

        if (empty($file) || !file_exists($filepath)) {
            echo json_encode(['success' => false, 'error' => 'Backup file not found']);
            exit;
        }

        cleanupOldBackups($backupsDir);

        echo json_encode([
            'success' => true,
            'file'    => $file,
            'size'    => filesize($filepath),
            'time'    => filemtime($filepath),
        ]);
        exit;
    }

    if ($_GET['action'] === 'cancel') {
        $file = $_SESSION['backup_file'] ?? '';
        $filepath = $backupsDir . '/' . $file;
        if (!empty($file) && file_exists($filepath)) {
            @unlink($filepath);
        }
        unset($_SESSION['backup_file'], $_SESSION['backup_tables'], $_SESSION['backup_index']);
        echo json_encode(['success' => true]);
        exit;
    }

    if ($_GET['action'] === 'download') {
        $file = $_GET['file'] ?? '';
        $file = basename($file);
        $filepath = $backupsDir . '/' . $file;
        if (file_exists($filepath) && str_starts_with($file, 'backup_')) {
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $file . '"');
            header('Content-Length: ' . filesize($filepath));
            readfile($filepath);
            exit;
        }
        echo json_encode(['success' => false, 'error' => 'File not found']);
        exit;
    }

    if ($_GET['action'] === 'email') {
        $file = $_GET['file'] ?? '';
        $emailString = $_GET['email'] ?? '';
        $file = basename($file);

        if (empty($emailString)) {
            echo json_encode(['success' => false, 'error' => 'No recipient email specified']);
            exit;
        }

        $emails = preg_split('/[\s,;]+/', $emailString);
        $validEmails = [];
        foreach ($emails as $email) {
            $email = trim($email);
            if (!empty($email)) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $validEmails[] = $email;
                } else {
                    echo json_encode(['success' => false, 'error' => 'Invalid email address: ' . htmlspecialchars($email)]);
                    exit;
                }
            }
        }

        if (empty($validEmails)) {
            echo json_encode(['success' => false, 'error' => 'No valid recipient email address found']);
            exit;
        }

        $filepath = $backupsDir . '/' . $file;
        if (!file_exists($filepath) || !str_starts_with($file, 'backup_')) {
            echo json_encode(['success' => false, 'error' => 'File not found']);
            exit;
        }

        $configRes = mysqli_query($conn, "SELECT * FROM `tolly_email_config` WHERE `id` = 1");
        $config = mysqli_fetch_assoc($configRes);

        $fromEmail = trim($config['from_email'] ?? '');
        $fromName = trim($config['from_name'] ?? '');

        if (empty($fromEmail)) {
            $fromEmail = 'backup@hitandfut.com';
        }
        if (empty($fromName)) {
            $fromName = 'HitandFut Backup';
        }

        require_once 'smtp_helper.php';

        try {
            MailSender::send(
                $config,
                $fromEmail,
                $fromName,
                $validEmails,
                'Database Backup - ' . date('j-F-Y'),
                "<h3>Database Backup</h3><p>Please find the database backup attached.</p>",
                $filepath,
                $file
            );
            echo json_encode(['success' => true, 'message' => 'Email sent to ' . implode(', ', $validEmails)]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => 'Error sending email: ' . $e->getMessage()]);
        }
        exit;
    }

    echo json_encode(['success' => false, 'error' => 'Unknown action']);
    exit;
}

function cleanupOldBackups(string $dir): void
{
    $files = glob($dir . '/backup_*.sql');
    if ($files === false || count($files) <= 5) {
        return;
    }
    usort($files, fn($a, $b) => filemtime($b) - filemtime($a));
    for ($i = 5; $i < count($files); $i++) {
        @unlink($files[$i]);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php include 'css.php'; ?>
</head>
<body class="page-header-fixed">
    <div class="overlay"></div>
    <main class="page-content content-wrap">
        <?php include 'navbar.php'; ?>
        <div class="page-sidebar sidebar">
            <?php include 'sidemenu.php'; ?>
        </div>
        <div class="page-inner">
            <div class="page-title">
                <h3>Database Backup</h3>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="#">Tools</a></li>
                        <li class="active">Database Backup</li>
                    </ol>
                </div>
            </div>
            <div id="main-wrapper">
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <h4 class="panel-title">Connection Details</h4>
                            </div>
                            <div class="panel-body">
                                <table class="table table-bordered">
                                    <tr><td><b>Host</b></td><td><?php echo htmlspecialchars($host); ?></td></tr>
                                    <tr><td><b>Database</b></td><td><?php echo htmlspecialchars($db); ?></td></tr>
                                    <tr><td><b>Username</b></td><td><?php echo htmlspecialchars($user); ?></td></tr>
                                    <tr><td><b>Password</b></td><td><?php echo htmlspecialchars($pass); ?></td></tr>
                                    <tr><td><b>Port</b></td><td><?php echo htmlspecialchars($port); ?></td></tr>
                                </table>
                                <button id="backupBtn" class="btn btn-danger btn-lg btn-block m-t-md">
                                    <i class="fa fa-database m-r-xs"></i> Create Backup
                                </button>
                                <div id="backupProgress" class="m-t-md" style="display:none;">
                                    <div class="progress progress-sm">
                                        <div id="progressBar" class="progress-bar progress-bar-success" role="progressbar" style="width: 0%"></div>
                                    </div>
                                    <div id="progressStatus" class="m-t-xs text-muted"></div>
                                    <div id="progressLog" class="m-t-sm" style="max-height:200px;overflow-y:auto;font-size:12px;"></div>
                                    <button id="cancelBtn" class="btn btn-warning btn-sm m-t-sm" style="display:none;">
                                        <i class="fa fa-times m-r-xs"></i> Cancel
                                    </button>
                                </div>
                                <div id="backupResult" class="m-t-md" style="display:none;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <h4 class="panel-title">Recent Backups</h4>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="backupsTable">
                                        <thead>
                                            <tr>
                                                <th>File Name</th>
                                                <th>Size</th>
                                                <th>Created</th>
                                                <th>Download</th>
                                                <th>Email</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($backups)): ?>
                                                <tr><td colspan="5" class="text-center">No backups yet</td></tr>
                                            <?php else: ?>
                                                <?php foreach ($backups as $b): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($b['name']); ?></td>
                                                        <td><?php echo round($b['size'] / 1024, 1); ?> KB</td>
                                                        <td><?php echo date('Y-m-d H:i:s', $b['time']); ?></td>
                                                        <td>
                                                            <a href="bkp.php?action=download&file=<?php echo urlencode($b['name']); ?>"
                                                               class="btn btn-sm btn-success">
                                                                <i class="fa fa-download"></i>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-sm btn-info email-btn"
                                                                    data-file="<?php echo htmlspecialchars($b['name']); ?>">
                                                                <i class="fa fa-envelope"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <h4 class="panel-title">Automated Backup Scheduler (CRON)</h4>
                            </div>
                            <div class="panel-body">
                                <div id="cronAlert" class="alert alert-info" style="display:none; border-radius:4px;"></div>
                                
                                <form id="cronForm" class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"><b>Current Status</b></label>
                                        <div class="col-sm-9" style="padding-top: 7px;">
                                            <?php if ((int)($cronConfig['is_active'] ?? 0) === 1): ?>
                                                <span class="label label-success"><i class="fa fa-check"></i> Active</span>
                                            <?php else: ?>
                                                <span class="label label-danger"><i class="fa fa-times"></i> Inactive / Deleted</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="cron_expression" class="col-sm-3 control-label"><b>CRON Expression</b></label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="cron_expression" name="cron_expression" 
                                                   value="<?php echo htmlspecialchars($cronConfig['cron_expression'] ?? '0 7 */7 * *'); ?>" placeholder="* * * * *">
                                            <p class="help-block text-muted" style="font-size:11px; margin-top:5px;">
                                                Format: <code>minute hour day-of-month month day-of-week</code> (e.g. <code>0 7 */7 * *</code> for every 7 days at 7:00 AM).
                                            </p>
                                        </div>
                                    </div>
                                    <?php if ($cronConfig['last_run'] ?? null): ?>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"><b>Last Executed</b></label>
                                        <div class="col-sm-9" style="padding-top: 7px; color: #475569;">
                                            <?php echo htmlspecialchars($cronConfig['last_run']); ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ((int)($cronConfig['is_active'] ?? 0) === 1 && ($cronConfig['next_run'] ?? null)): ?>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"><b>Next Scheduled Run</b></label>
                                        <div class="col-sm-9" style="padding-top: 7px; color: #475569; font-weight: 600;">
                                            <?php echo htmlspecialchars($cronConfig['next_run']); ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <button type="button" id="saveCronBtn" class="btn btn-success">
                                                <i class="fa fa-clock-o m-r-xs"></i> Schedule / Update Cron
                                            </button>
                                            <?php if ((int)($cronConfig['is_active'] ?? 0) === 1): ?>
                                            <button type="button" id="deleteCronBtn" class="btn btn-danger m-l-xs">
                                                <i class="fa fa-trash m-r-xs"></i> Delete Schedule
                                            </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="cd-overlay"></div>

    <div class="modal fade" id="emailModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    <h4 class="modal-title">Email Backup</h4>
                </div>
                <div class="modal-body">
                    <p>Send <b id="emailFileName"></b> to:</p>
                    <input type="email" class="form-control" id="emailInput" placeholder="Enter email address">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-info" id="sendEmailBtn">
                        <i class="fa fa-paper-plane m-r-xs"></i> Send
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php include 'js.php'; ?>
    <script>
    $(document).ready(function() {

        var backupRunning = false;

        function addLog(msg, type) {
            var cls = type === 'error' ? 'text-danger' : type === 'success' ? 'text-success' : '';
            $('#progressLog').append('<div class="' + cls + '">' + msg + '</div>');
            var log = document.getElementById('progressLog');
            log.scrollTop = log.scrollHeight;
        }

        function resetBtn() {
            $('#backupBtn').prop('disabled', false).html('<i class="fa fa-database m-r-xs"></i> Create Backup');
            backupRunning = false;
        }

        $('#backupBtn').on('click', function() {
            if (backupRunning) return;
            backupRunning = true;
            var btn = $(this);
            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Starting...');
            $('#backupResult').hide();
            $('#backupProgress').show();
            $('#progressBar').css('width', '0%').removeClass('progress-bar-danger progress-bar-success').addClass('progress-bar-striped active');
            $('#progressLog').html('');
            $('#progressStatus').text('Fetching table list...');
            $('#cancelBtn').show();

            $.ajax({
                url: 'bkp.php',
                data: { action: 'get_tables' },
                dataType: 'json',
                success: function(res) {
                    if (!res.success) {
                        addLog('Error: ' + res.error, 'error');
                        $('#progressBar').addClass('progress-bar-danger').removeClass('active progress-bar-striped');
                        $('#progressStatus').text('Failed to start backup.');
                        resetBtn();
                        $('#cancelBtn').hide();
                        return;
                    }

                    var tables = res.tables;
                    var total = res.total;
                    addLog('Found ' + total + ' tables. Starting backup...', 'info');
                    $('#progressStatus').text('Backing up 0 of ' + total + ' tables...');

                    var i = 0;
                    function backupNext() {
                        if (i >= tables.length) {
                            $.ajax({
                                url: 'bkp.php',
                                data: { action: 'finalize' },
                                dataType: 'json',
                                success: function(fin) {
                                    if (fin.success) {
                                        addLog('Backup complete: ' + fin.file, 'success');
                                        $('#progressBar').css('width', '100%').removeClass('active progress-bar-striped').addClass('progress-bar-success');
                                        $('#progressStatus').text('Backup complete!');
                                        $('#cancelBtn').hide();
                                        var html = '<div class="alert alert-success">' +
                                            '<b>Backup created!</b> ' + fin.file +
                                            ' (' + (fin.size / 1024).toFixed(1) + ' KB)' +
                                            ' <a href="bkp.php?action=download&file=' + encodeURIComponent(fin.file) + '" class="btn btn-sm btn-success m-l-sm"><i class="fa fa-download"></i> Download</a>' +
                                            ' <button class="btn btn-sm btn-info m-l-sm email-btn" data-file="' + fin.file + '"><i class="fa fa-envelope"></i> Email</button>' +
                                            '</div>';
                                        $('#backupResult').html(html).show();
                                        setTimeout(function() { location.reload(); }, 2000);
                                    } else {
                                        addLog('Error finalizing: ' + fin.error, 'error');
                                        $('#progressBar').addClass('progress-bar-danger').removeClass('active progress-bar-striped');
                                    }
                                    resetBtn();
                                },
                                error: function(xhr) {
                                    addLog('Finalize failed: server error', 'error');
                                    $('#progressBar').addClass('progress-bar-danger').removeClass('active progress-bar-striped');
                                    resetBtn();
                                }
                            });
                            return;
                        }

                        addLog('Backing up table: ' + tables[i] + '...');
                        $.ajax({
                            url: 'bkp.php',
                            data: { action: 'backup_table' },
                            dataType: 'json',
                            success: function(res) {
                                if (!res.success) {
                                    addLog('ERROR on table ' + (res.table || tables[i]) + ': ' + res.error, 'error');
                                    $('#progressBar').addClass('progress-bar-danger').removeClass('active progress-bar-striped');
                                    $('#progressStatus').text('Backup failed at table: ' + (res.table || tables[i]));
                                    $('#cancelBtn').hide();
                                    resetBtn();
                                    return;
                                }
                                var pct = Math.round((res.current / res.total) * 100);
                                $('#progressBar').css('width', pct + '%');
                                $('#progressStatus').text('Backed up ' + res.current + ' of ' + res.total + ' tables (' + res.rows + ' rows from ' + res.table + ')');
                                addLog('&#10003; ' + res.table + ' (' + res.rows + ' rows)', 'success');
                                i++;
                                backupNext();
                            },
                            error: function(xhr) {
                                addLog('Server error backing up ' + tables[i] + ': HTTP ' + xhr.status, 'error');
                                $('#progressBar').addClass('progress-bar-danger').removeClass('active progress-bar-striped');
                                $('#progressStatus').text('Backup failed due to server error.');
                                $('#cancelBtn').hide();
                                resetBtn();
                            }
                        });
                    }
                    backupNext();
                },
                error: function(xhr) {
                    addLog('Could not connect to server. HTTP ' + xhr.status, 'error');
                    $('#progressBar').addClass('progress-bar-danger').removeClass('active progress-bar-striped');
                    $('#progressStatus').text('Connection failed.');
                    resetBtn();
                    $('#cancelBtn').hide();
                }
            });
        });

        $('#cancelBtn').on('click', function() {
            if (!backupRunning) return;
            $.ajax({
                url: 'bkp.php',
                data: { action: 'cancel' },
                dataType: 'json',
                success: function() {
                    addLog('Backup cancelled by user.', 'error');
                    $('#progressBar').addClass('progress-bar-danger').removeClass('active progress-bar-striped');
                    $('#progressStatus').text('Backup cancelled.');
                    $('#cancelBtn').hide();
                    resetBtn();
                }
            });
        });

        var preconfiguredEmails = <?php echo json_encode($preconfiguredEmails); ?>;

        $(document).on('click', '.email-btn', function() {
            $('#emailFileName').text($(this).data('file'));
            $('#emailInput').val(preconfiguredEmails);
            $('#emailModal').modal('show');
        });

        $('#sendEmailBtn').on('click', function() {
            var file = $('#emailFileName').text();
            var email = $('#emailInput').val();
            var btn = $(this);
            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Sending...');
            $.ajax({
                url: 'bkp.php',
                data: { action: 'email', file: file, email: email },
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        toastr.success(res.message);
                        $('#emailModal').modal('hide');
                    } else {
                        toastr.error(res.error);
                    }
                    btn.prop('disabled', false).html('<i class="fa fa-paper-plane m-r-xs"></i> Send');
                },
                error: function() {
                    toastr.error('Server error while sending email.');
                    btn.prop('disabled', false).html('<i class="fa fa-paper-plane m-r-xs"></i> Send');
                }
            });
        });

        $('#saveCronBtn').on('click', function() {
            var btn = $(this);
            var expr = $('#cron_expression').val();
            var alertDiv = $('#cronAlert');
            
            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
            alertDiv.hide().removeClass('alert-success alert-danger').addClass('alert-info').text('Saving schedule...');
            alertDiv.show();

            $.ajax({
                url: 'bkp.php?action=save_cron',
                type: 'POST',
                data: { cron_expression: expr },
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        alertDiv.removeClass('alert-info alert-danger').addClass('alert-success').text(res.message);
                        setTimeout(function() { location.reload(); }, 1500);
                    } else {
                        alertDiv.removeClass('alert-info alert-success').addClass('alert-danger').text(res.error);
                        btn.prop('disabled', false).html('<i class="fa fa-clock-o m-r-xs"></i> Schedule / Update Cron');
                    }
                },
                error: function() {
                    alertDiv.removeClass('alert-info alert-success').addClass('alert-danger').text('Server error while saving schedule.');
                    btn.prop('disabled', false).html('<i class="fa fa-clock-o m-r-xs"></i> Schedule / Update Cron');
                }
            });
        });

        $('#deleteCronBtn').on('click', function() {
            var btn = $(this);
            var alertDiv = $('#cronAlert');
            
            if(!confirm('Are you sure you want to delete/deactivate this backup schedule?')) {
                return;
            }
            
            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Deleting...');
            alertDiv.hide().removeClass('alert-success alert-danger').addClass('alert-info').text('Deleting schedule...');
            alertDiv.show();

            $.ajax({
                url: 'bkp.php?action=delete_cron',
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        alertDiv.removeClass('alert-info alert-danger').addClass('alert-success').text(res.message);
                        setTimeout(function() { location.reload(); }, 1500);
                    } else {
                        alertDiv.removeClass('alert-info alert-success').addClass('alert-danger').text(res.error);
                        btn.prop('disabled', false).html('<i class="fa fa-trash m-r-xs"></i> Delete Schedule');
                    }
                },
                error: function() {
                    alertDiv.removeClass('alert-info alert-success').addClass('alert-danger').text('Server error while deleting schedule.');
                    btn.prop('disabled', false).html('<i class="fa fa-trash m-r-xs"></i> Delete Schedule');
                }
            });
        });
    });
    </script>
</body>
</html>
