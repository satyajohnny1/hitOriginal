<?php
declare(strict_types=1);
include 'sessionCheck.php';
include 'db.php';
error_reporting(E_ERROR);

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
        $email = $_GET['email'] ?? '';
        $file = basename($file);

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'error' => 'Invalid email address']);
            exit;
        }

        $filepath = $backupsDir . '/' . $file;
        if (!file_exists($filepath) || !str_starts_with($file, 'backup_')) {
            echo json_encode(['success' => false, 'error' => 'File not found']);
            exit;
        }

        $from = 'backup@hitandfut.com';
        $fromName = 'HitandFut Backup';
        $subject = 'Database Backup - ' . date('j-F-Y');
        $htmlContent = '<h3>Database Backup</h3><p>Please find the database backup attached.</p>';

        $semiRand = md5((string)time());
        $mimeBoundary = "==Multipart_Boundary_x{$semiRand}x";

        $headers = "From: {$fromName} <{$from}>";
        $headers .= "\nMIME-Version: 1.0\n";
        $headers .= "Content-Type: multipart/mixed;\n boundary=\"{$mimeBoundary}\"";

        $message = "--{$mimeBoundary}\n";
        $message .= "Content-Type: text/html; charset=\"UTF-8\"\n";
        $message .= "Content-Transfer-Encoding: 7bit\n\n";
        $message .= $htmlContent . "\n\n";

        $fp = fopen($filepath, 'rb');
        $data = fread($fp, filesize($filepath));
        fclose($fp);
        $data = chunk_split(base64_encode($data));

        $message .= "--{$mimeBoundary}\n";
        $message .= "Content-Type: application/octet-stream; name=\"{$file}\"\n";
        $message .= "Content-Description: {$file}\n";
        $message .= "Content-Disposition: attachment;\n filename=\"{$file}\"; size=" . filesize($filepath) . ";\n";
        $message .= "Content-Transfer-Encoding: base64\n\n";
        $message .= $data . "\n\n";
        $message .= "--{$mimeBoundary}--";

        $returnPath = "-f {$from}";
        $sent = @mail($email, $subject, $message, $headers, $returnPath);

        echo json_encode($sent
            ? ['success' => true, 'message' => 'Email sent to ' . $email]
            : ['success' => false, 'error' => 'Failed to send email. Check server mail config.']
        );
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

        $(document).on('click', '.email-btn', function() {
            $('#emailFileName').text($(this).data('file'));
            $('#emailInput').val('');
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
    });
    </script>
</body>
</html>
