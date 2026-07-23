<?php
declare(strict_types=1);
include 'sessionCheck.php';
include 'db.php';
error_reporting(E_ERROR);

$backupsDir = __DIR__ . '/backups';
if (!is_dir($backupsDir)) {
    mkdir($backupsDir, 0755, true);
}

$host = $servername;
$db   = $dbname;
$user = $username;
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

    if ($_GET['action'] === 'backup') {
        $tables = [];
        $res = mysqli_query($conn, 'SHOW TABLES');
        while ($row = mysqli_fetch_row($res)) {
            $tables[] = $row[0];
        }

        $sql = "-- HitandFut Database Backup\n";
        $sql .= "-- Date: " . date('Y-m-d H:i:s') . "\n";
        $sql .= "-- Database: {$db}\n\n";

        foreach ($tables as $table) {
            $createRes = mysqli_query($conn, 'SHOW CREATE TABLE `' . $table . '`');
            $createRow = mysqli_fetch_row($createRes);
            $sql .= "DROP TABLE IF EXISTS `{$table}`;\n";
            $sql .= $createRow[1] . ";\n\n";

            $dataRes = mysqli_query($conn, "SELECT * FROM `{$table}`");
            $numFields = mysqli_num_fields($dataRes);
            $numRows = mysqli_num_rows($dataRes);

            $counter = 1;
            while ($row = mysqli_fetch_row($dataRes)) {
                if ($counter === 1) {
                    $sql .= "INSERT INTO `{$table}` VALUES(";
                } else {
                    $sql .= "(";
                }
                for ($j = 0; $j < $numFields; $j++) {
                    $row[$j] = addslashes((string)$row[$j]);
                    $sql .= '"' . $row[$j] . '"';
                    if ($j < $numFields - 1) {
                        $sql .= ',';
                    }
                }
                $sql .= ($numRows === $counter) ? ");\n" : "),\n";
                $counter++;
            }
            $sql .= "\n\n";
        }

        $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        $filepath = $backupsDir . '/' . $filename;
        file_put_contents($filepath, $sql);

        cleanupOldBackups($backupsDir);

        echo json_encode([
            'success' => true,
            'file' => $filename,
            'size' => filesize($filepath),
            'time' => filemtime($filepath),
        ]);
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
                                    <tr><td><b>Password</b></td><td><span id="pwMask">********</span><span id="pwText" style="display:none;"><?php echo htmlspecialchars($password); ?></span> <a href="javascript:void(0)" id="togglePw" class="text-muted"><i class="fa fa-eye"></i></a></td></tr>
                                    <tr><td><b>Port</b></td><td><?php echo htmlspecialchars($port); ?></td></tr>
                                </table>
                                <button id="backupBtn" class="btn btn-danger btn-lg btn-block m-t-md">
                                    <i class="fa fa-database m-r-xs"></i> Create Backup
                                </button>
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
        $('#togglePw').click(function() {
            var icon = $(this).find('i');
            if ($('#pwText').is(':visible')) {
                $('#pwText').hide();
                $('#pwMask').show();
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            } else {
                $('#pwMask').hide();
                $('#pwText').show();
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            }
        });

        $('#backupBtn').click(function() {
            var btn = $(this);
            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Backing up...');
            $.get('bkp.php', { action: 'backup' }, function(res) {
                if (res.success) {
                    var html = '<div class="alert alert-success">' +
                        '<b>Backup created!</b> ' + res.file +
                        ' (' + (res.size / 1024).toFixed(1) + ' KB)' +
                        ' <a href="bkp.php?action=download&file=' + encodeURIComponent(res.file) + '" class="btn btn-sm btn-success m-l-sm"><i class="fa fa-download"></i> Download</a>' +
                        ' <button class="btn btn-sm btn-info m-l-sm email-btn" data-file="' + res.file + '"><i class="fa fa-envelope"></i> Email</button>' +
                        '</div>';
                    $('#backupResult').html(html).show();
                    setTimeout(function() { location.reload(); }, 2000);
                } else {
                    $('#backupResult').html('<div class="alert alert-danger">Error: ' + res.error + '</div>').show();
                }
                btn.prop('disabled', false).html('<i class="fa fa-database m-r-xs"></i> Create Backup');
            }, 'json');
        });

        $(document).on('click', '.email-btn', function() {
            $('#emailFileName').text($(this).data('file'));
            $('#emailInput').val('');
            $('#emailModal').modal('show');
        });

        $('#sendEmailBtn').click(function() {
            var file = $('#emailFileName').text();
            var email = $('#emailInput').val();
            var btn = $(this);
            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Sending...');
            $.get('bkp.php', { action: 'email', file: file, email: email }, function(res) {
                if (res.success) {
                    toastr.success(res.message);
                    $('#emailModal').modal('hide');
                } else {
                    toastr.error(res.error);
                }
                btn.prop('disabled', false).html('<i class="fa fa-paper-plane m-r-xs"></i> Send');
            }, 'json');
        });
    });
    </script>
</body>
</html>
