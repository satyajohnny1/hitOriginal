<?php
declare(strict_types=1);
include 'db.php';
error_reporting(E_ERROR);

$startTime = microtime(true);
$errors = [];

// 1. Check Database Connection
$dbStatus = 'healthy';
$dbLatency = 0.0;
if (!$conn) {
    $dbStatus = 'unhealthy';
    $errors[] = 'Database connection failed: ' . mysqli_connect_error();
} else {
    $dbStart = microtime(true);
    $dbQuery = @mysqli_query($conn, "SELECT 1");
    if (!$dbQuery) {
        $dbStatus = 'unhealthy';
        $errors[] = 'Database query failed: ' . mysqli_error($conn);
    } else {
        $dbLatency = round((microtime(true) - $dbStart) * 1000, 2);
    }
}

// 2. Check Backups Directory Writable
$backupsDir = __DIR__ . '/backups';
$backupsStatus = 'healthy';
$backupsCount = 0;
if (!is_dir($backupsDir)) {
    if (!@mkdir($backupsDir, 0755, true)) {
        $backupsStatus = 'unhealthy';
        $errors[] = 'Backups directory does not exist and cannot be created';
    }
}
if ($backupsStatus === 'healthy') {
    if (!is_writable($backupsDir)) {
        $backupsStatus = 'unhealthy';
        $errors[] = 'Backups directory is not writable';
    } else {
        $files = glob($backupsDir . '/backup_*.sql');
        $backupsCount = $files !== false ? count($files) : 0;
    }
}

// 3. Check Email Configuration Status
$emailStatus = 'healthy';
$emailDetails = [];
$emailConfigRes = @mysqli_query($conn, "SELECT * FROM `tolly_email_config` WHERE `id` = 1");
if ($emailConfigRes) {
    $emailConfig = mysqli_fetch_assoc($emailConfigRes);
    if ($emailConfig) {
        $provider = $emailConfig['email_provider'] ?? 'smtp';
        $emailDetails['provider'] = $provider;
        $emailDetails['from_email'] = $emailConfig['from_email'] ?? 'Not set';
        
        if ($provider === 'mailersend_api') {
            $hasToken = !empty($emailConfig['mailersend_api_token']);
            $emailDetails['has_api_token'] = $hasToken;
            if (!$hasToken) {
                $emailStatus = 'warning';
                $errors[] = 'MailerSend API Token is empty';
            }
        } else {
            $host = $emailConfig['smtp_host'] ?? '';
            $port = (int)($emailConfig['smtp_port'] ?? 587);
            $emailDetails['smtp_host'] = $host;
            $emailDetails['smtp_port'] = $port;
            
            if (empty($host)) {
                $emailStatus = 'warning';
                $errors[] = 'SMTP Host is not configured';
            } else {
                // Try a quick port connection check (2 second timeout)
                $socketHost = ($emailConfig['smtp_secure'] === 'ssl') ? 'ssl://' . $host : $host;
                $socket = @fsockopen($socketHost, $port, $errno, $errstr, 2);
                if (!$socket) {
                    $emailStatus = 'unhealthy';
                    $errors[] = "SMTP Connection check failed to $host:$port - $errstr ($errno)";
                } else {
                    fclose($socket);
                }
            }
        }
    } else {
        $emailStatus = 'unhealthy';
        $errors[] = 'Email configuration row is missing';
    }
} else {
    $emailStatus = 'unhealthy';
    $errors[] = 'Email config table does not exist or failed to query';
}

// 4. Check Cron Schedule Status
$cronStatus = 'healthy';
$cronDetails = [];
$cronConfigRes = @mysqli_query($conn, "SELECT * FROM `tolly_cron_config` WHERE `id` = 1");
if ($cronConfigRes) {
    $cronConfig = mysqli_fetch_assoc($cronConfigRes);
    if ($cronConfig) {
        $cronDetails['expression'] = $cronConfig['cron_expression'] ?? 'Not set';
        $cronDetails['is_active'] = (int)($cronConfig['is_active'] ?? 0) === 1;
        $cronDetails['last_run'] = $cronConfig['last_run'] ?? 'Never';
        $cronDetails['next_run'] = $cronConfig['next_run'] ?? 'Never';
    }
}

// System Details
$diskFree = @disk_free_space(__DIR__);
$diskTotal = @disk_total_space(__DIR__);
$diskUsagePct = ($diskTotal > 0) ? round((($diskTotal - $diskFree) / $diskTotal) * 100, 1) : 0.0;
$systemLatency = round((microtime(true) - $startTime) * 1000, 2);

$isHealthy = (count($errors) === 0);
$overallStatus = $isHealthy ? 'healthy' : 'unhealthy';

// Output JSON if format=json is specified
if ((isset($_GET['format']) && $_GET['format'] === 'json') || 
    (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => $overallStatus,
        'timestamp' => date('Y-m-d H:i:s'),
        'latency_ms' => $systemLatency,
        'php_version' => PHP_VERSION,
        'system' => [
            'os' => PHP_OS,
            'memory_usage' => memory_get_usage(),
            'disk_free_bytes' => $diskFree,
            'disk_usage_pct' => $diskUsagePct
        ],
        'database' => [
            'status' => $dbStatus,
            'latency_ms' => $dbLatency
        ],
        'backups' => [
            'status' => $backupsStatus,
            'count' => $backupsCount
        ],
        'email' => [
            'status' => $emailStatus,
            'details' => $emailDetails
        ],
        'cron' => $cronDetails,
        'errors' => $errors
    ], JSON_PRETTY_PRINT);
    exit;
}

// Default HTML Dashboard
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Server Health Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            margin: 0;
            padding: 40px 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
        }
        .status-badge {
            font-size: 14px;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .status-healthy {
            background-color: #dcfce7;
            color: #15803d;
        }
        .status-unhealthy {
            background-color: #fee2e2;
            color: #b91c1c;
        }
        .card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
            margin-bottom: 20px;
        }
        .card-title {
            font-size: 16px;
            font-weight: 600;
            margin-top: 0;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #334155;
        }
        .metric-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        @media (max-width: 600px) {
            .metric-grid {
                grid-template-columns: 1fr;
            }
        }
        .metric {
            background: #f8fafc;
            padding: 16px;
            border-radius: 8px;
            border: 1px solid #f1f5f9;
        }
        .metric-label {
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }
        .metric-value {
            font-size: 18px;
            font-weight: 600;
            color: #0f172a;
        }
        .dot {
            height: 10px;
            width: 10px;
            border-radius: 50%;
            display: inline-block;
        }
        .dot-healthy { background-color: #22c55e; }
        .dot-warning { background-color: #f59e0b; }
        .dot-unhealthy { background-color: #ef4444; }
        .error-log {
            background: #fee2e2;
            border: 1px solid #fca5a5;
            border-radius: 8px;
            color: #991b1b;
            padding: 16px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .error-log h4 {
            margin-top: 0;
            margin-bottom: 8px;
            font-weight: 600;
        }
        .error-log ul {
            margin: 0;
            padding-left: 20px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            margin-top: 40px;
        }
        .footer a {
            color: #64748b;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>System Health Dashboard</h1>
            <span class="status-badge <?php echo $isHealthy ? 'status-healthy' : 'status-unhealthy'; ?>">
                <i class="fa <?php echo $isHealthy ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
                <?php echo $isHealthy ? 'ALL SYSTEMS OPERATIONAL' : 'SYSTEM ISSUES DETECTED'; ?>
            </span>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="error-log">
                <h4>System Errors</h4>
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li><?php echo htmlspecialchars($err); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Server Card -->
        <div class="card">
            <div class="card-title">
                <span><i class="fa fa-hdd-o m-r-xs"></i> Server Environment</span>
                <span class="dot dot-healthy"></span>
            </div>
            <div class="metric-grid">
                <div class="metric">
                    <div class="metric-label">PHP Version</div>
                    <div class="metric-value"><?php echo PHP_VERSION; ?></div>
                </div>
                <div class="metric">
                    <div class="metric-label">Operating System</div>
                    <div class="metric-value"><?php echo PHP_OS; ?></div>
                </div>
                <div class="metric">
                    <div class="metric-label">Free Disk Space</div>
                    <div class="metric-value"><?php echo $diskFree ? round($diskFree / (1024 * 1024 * 1024), 2) . ' GB' : 'Unknown'; ?></div>
                </div>
                <div class="metric">
                    <div class="metric-label">Disk Usage Percentage</div>
                    <div class="metric-value"><?php echo $diskUsagePct; ?>%</div>
                </div>
            </div>
        </div>

        <!-- Database Card -->
        <div class="card">
            <div class="card-title">
                <span><i class="fa fa-database m-r-xs"></i> MySQL Database Connection</span>
                <span class="dot dot-<?php echo $dbStatus; ?>"></span>
            </div>
            <div class="metric-grid">
                <div class="metric">
                    <div class="metric-label">Status</div>
                    <div class="metric-value" style="color: <?php echo $dbStatus === 'healthy' ? '#15803d' : '#b91c1c'; ?>;">
                        <?php echo strtoupper($dbStatus); ?>
                    </div>
                </div>
                <div class="metric">
                    <div class="metric-label">Latency / Response Time</div>
                    <div class="metric-value"><?php echo $dbLatency; ?> ms</div>
                </div>
            </div>
        </div>

        <!-- Mailer & SMTP Card -->
        <div class="card">
            <div class="card-title">
                <span><i class="fa fa-envelope-o m-r-xs"></i> Mail Service Integration</span>
                <span class="dot dot-<?php echo $emailStatus; ?>"></span>
            </div>
            <div class="metric-grid">
                <div class="metric">
                    <div class="metric-label">Email Provider</div>
                    <div class="metric-value"><?php echo htmlspecialchars(strtoupper($emailDetails['provider'] ?? 'NOT CONFIG')); ?></div>
                </div>
                <div class="metric">
                    <div class="metric-label">Sender Address (From)</div>
                    <div class="metric-value"><?php echo htmlspecialchars($emailDetails['from_email'] ?? 'NOT SET'); ?></div>
                </div>
            </div>
        </div>

        <!-- Backups & Cron Card -->
        <div class="card">
            <div class="card-title">
                <span><i class="fa fa-clock-o m-r-xs"></i> Database Backups & Cron Scheduler</span>
                <span class="dot dot-<?php echo ($cronDetails['is_active'] ?? false) ? 'healthy' : 'warning'; ?>"></span>
            </div>
            <div class="metric-grid">
                <div class="metric">
                    <div class="metric-label">Backup Count</div>
                    <div class="metric-value"><?php echo $backupsCount; ?> Files</div>
                </div>
                <div class="metric">
                    <div class="metric-label">CRON Scheduler Status</div>
                    <div class="metric-value">
                        <?php echo ($cronDetails['is_active'] ?? false) ? 'ACTIVE' : 'INACTIVE'; ?>
                    </div>
                </div>
                <div class="metric">
                    <div class="metric-label">Next Scheduled Run</div>
                    <div class="metric-value" style="font-size:15px;"><?php echo htmlspecialchars($cronDetails['next_run'] ?? 'Never'); ?></div>
                </div>
                <div class="metric">
                    <div class="metric-label">Last Executed</div>
                    <div class="metric-value" style="font-size:15px;"><?php echo htmlspecialchars($cronDetails['last_run'] ?? 'Never'); ?></div>
                </div>
            </div>
        </div>

        <div class="footer">
            Page loaded in <?php echo $systemLatency; ?> ms | Exposing API Endpoint at <a href="health.php?format=json" target="_blank">health.php?format=json</a>
        </div>
    </div>
</body>
</html>
