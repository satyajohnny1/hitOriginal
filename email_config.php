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

// Handle Test Email request
if (isset($_GET['action']) && $_GET['action'] === 'test') {
    header('Content-Type: application/json');
    $provider = trim($_POST['email_provider'] ?? 'smtp');
    $apiToken = trim($_POST['mailersend_api_token'] ?? '');
    
    $host = trim($_POST['smtp_host'] ?? '');
    $port = (int)($_POST['smtp_port'] ?? 587);
    $username = trim($_POST['smtp_username'] ?? '');
    $password = trim($_POST['smtp_password'] ?? '');
    $secure = trim($_POST['smtp_secure'] ?? 'tls');
    
    $fromEmail = trim($_POST['from_email'] ?? '');
    $fromName = trim($_POST['from_name'] ?? '');
    $recipients = trim($_POST['recipient_emails'] ?? '');

    if ($provider === 'mailersend_api') {
        if (empty($apiToken)) {
            echo json_encode(['success' => false, 'error' => 'Please fill in MailerSend API Token to test.']);
            exit;
        }
    } else {
        if (empty($host)) {
            echo json_encode(['success' => false, 'error' => 'Please fill in SMTP Host to test.']);
            exit;
        }
    }

    if (empty($fromEmail) || empty($recipients)) {
        echo json_encode(['success' => false, 'error' => 'Please fill in Sender Email and Recipient Emails to run the test.']);
        exit;
    }

    $emails = preg_split('/[\s,;]+/', $recipients);
    $validEmails = [];
    foreach ($emails as $email) {
        $email = trim($email);
        if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $validEmails[] = $email;
        }
    }

    if (empty($validEmails)) {
        echo json_encode(['success' => false, 'error' => 'No valid recipient email address found.']);
        exit;
    }

    $testConfig = [
        'email_provider' => $provider,
        'mailersend_api_token' => $apiToken,
        'smtp_host' => $host,
        'smtp_port' => $port,
        'smtp_username' => $username,
        'smtp_password' => $password,
        'smtp_secure' => $secure
    ];

    require_once 'smtp_helper.php';
    try {
        MailSender::send(
            $testConfig,
            $fromEmail,
            $fromName,
            $validEmails,
            "Email Configuration Test Mail",
            "<h3>Connection Test Success!</h3><p>Your email config works! The connection was established and delivered correctly using the " . ($provider === 'mailersend_api' ? 'MailerSend HTTP API' : 'SMTP protocol') . ".</p>"
        );
        echo json_encode(['success' => true, 'message' => 'Test email sent successfully to ' . implode(', ', $validEmails)]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => 'Test Failed: ' . $e->getMessage()]);
    }
    exit;
}

$message = '';
$msgType = 'success';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $provider = trim($_POST['email_provider'] ?? 'smtp');
    $apiToken = trim($_POST['mailersend_api_token'] ?? '');
    
    $host = trim($_POST['smtp_host'] ?? '');
    $port = (int)($_POST['smtp_port'] ?? 587);
    $username = trim($_POST['smtp_username'] ?? '');
    $password = trim($_POST['smtp_password'] ?? '');
    $secure = trim($_POST['smtp_secure'] ?? 'tls');
    
    $fromEmail = trim($_POST['from_email'] ?? '');
    $fromName = trim($_POST['from_name'] ?? '');
    $recipients = trim($_POST['recipient_emails'] ?? '');

    $stmt = mysqli_prepare($conn, "UPDATE `tolly_email_config` SET `email_provider` = ?, `mailersend_api_token` = ?, `smtp_host` = ?, `smtp_port` = ?, `smtp_username` = ?, `smtp_password` = ?, `smtp_secure` = ?, `from_email` = ?, `from_name` = ?, `recipient_emails` = ? WHERE `id` = 1");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssissssss", $provider, $apiToken, $host, $port, $username, $password, $secure, $fromEmail, $fromName, $recipients);
        if (mysqli_stmt_execute($stmt)) {
            $message = "Configuration saved successfully!";
        } else {
            $message = "Failed to save configuration: " . mysqli_stmt_error($stmt);
            $msgType = 'danger';
        }
        mysqli_stmt_close($stmt);
    } else {
        $message = "Failed to prepare query: " . mysqli_error($conn);
        $msgType = 'danger';
    }
}

// Fetch current config
$configRes = mysqli_query($conn, "SELECT * FROM `tolly_email_config` WHERE `id` = 1");
$config = mysqli_fetch_assoc($configRes) ?: [
    'email_provider' => 'smtp',
    'mailersend_api_token' => '',
    'smtp_host' => 'smtp.mailersend.net',
    'smtp_port' => 587,
    'smtp_username' => '',
    'smtp_password' => '',
    'smtp_secure' => 'tls',
    'from_email' => 'backup@hitandfut.com',
    'from_name' => 'HitandFut Backup',
    'recipient_emails' => ''
];
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
                <h3>Email Config</h3>
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="#">Tools</a></li>
                        <li class="active">Email Config</li>
                    </ol>
                </div>
            </div>
            <div id="main-wrapper">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-white">
                            <div class="panel-heading">
                                <h4 class="panel-title">Email Server & Backup Delivery Settings</h4>
                            </div>
                            <div class="panel-body">
                                <?php if (!empty($message)): ?>
                                    <div class="alert alert-<?php echo $msgType; ?> alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <?php echo htmlspecialchars($message); ?>
                                    </div>
                                <?php endif; ?>

                                <div id="testResult" class="alert alert-info" style="display:none;"></div>

                                <form id="smtpForm" action="email_config.php" method="POST">
                                    <div class="form-group">
                                        <label for="email_provider"><b>Email Delivery Method</b></label>
                                        <select class="form-control" id="email_provider" name="email_provider">
                                            <option value="smtp" <?php echo ($config['email_provider'] ?? 'smtp') === 'smtp' ? 'selected' : ''; ?>>General SMTP (Any Provider)</option>
                                            <option value="mailersend_api" <?php echo ($config['email_provider'] ?? '') === 'mailersend_api' ? 'selected' : ''; ?>>MailerSend HTTP API (via API Token)</option>
                                        </select>
                                    </div>

                                    <!-- MailerSend API Section -->
                                    <div id="mailersend_api_section" style="display:none;">
                                        <div class="form-group">
                                            <label for="mailersend_api_token"><b>MailerSend API Token</b></label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="mailersend_api_token" name="mailersend_api_token" 
                                                       value="<?php echo htmlspecialchars($config['mailersend_api_token'] ?? ''); ?>" placeholder="mlsn.cxxxxxxxx...">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button" id="toggleApiToken">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </span>
                                            </div>
                                            <p class="help-block text-muted" style="font-size:11px;">Enter the API token generated in your app.mailersend.com account.</p>
                                        </div>
                                    </div>

                                    <!-- SMTP Config Section -->
                                    <div id="smtp_section" style="display:none;">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="smtp_host"><b>SMTP Server Host</b></label>
                                                    <input type="text" class="form-control" id="smtp_host" name="smtp_host" 
                                                           value="<?php echo htmlspecialchars($config['smtp_host'] ?? ''); ?>" placeholder="smtp.mailersend.net">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="smtp_port"><b>SMTP Port</b></label>
                                                    <input type="number" class="form-control" id="smtp_port" name="smtp_port" 
                                                           value="<?php echo htmlspecialchars((string)($config['smtp_port'] ?? 587)); ?>" placeholder="587">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="smtp_secure"><b>SMTP Security</b></label>
                                            <select class="form-control" id="smtp_secure" name="smtp_secure">
                                                <option value="tls" <?php echo ($config['smtp_secure'] ?? '') === 'tls' ? 'selected' : ''; ?>>STARTTLS (Port 587 / 2525)</option>
                                                <option value="ssl" <?php echo ($config['smtp_secure'] ?? '') === 'ssl' ? 'selected' : ''; ?>>SSL/TLS (Port 465)</option>
                                                <option value="none" <?php echo ($config['smtp_secure'] ?? '') === 'none' ? 'selected' : ''; ?>>None (Plain SMTP)</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="smtp_username"><b>SMTP Username / Login Email</b></label>
                                            <input type="text" class="form-control" id="smtp_username" name="smtp_username" 
                                                   value="<?php echo htmlspecialchars($config['smtp_username'] ?? ''); ?>" placeholder="MS_XXXXXX@...">
                                        </div>
                                        <div class="form-group">
                                            <label for="smtp_password"><b>SMTP Password / Auth Token</b></label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="smtp_password" name="smtp_password" 
                                                       value="<?php echo htmlspecialchars($config['smtp_password'] ?? ''); ?>" placeholder="Enter SMTP password">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button" id="togglePassword">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="form-group">
                                        <label for="from_email"><b>Sender Email Address (From)</b></label>
                                        <input type="email" class="form-control" id="from_email" name="from_email" 
                                               value="<?php echo htmlspecialchars($config['from_email'] ?? 'backup@hitandfut.com'); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="from_name"><b>Sender Name</b></label>
                                        <input type="text" class="form-control" id="from_name" name="from_name" 
                                               value="<?php echo htmlspecialchars($config['from_name'] ?? 'HitandFut Backup'); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient_emails"><b>Pre-configured Recipient Emails (Comma Separated)</b></label>
                                        <textarea class="form-control" id="recipient_emails" name="recipient_emails" rows="3" 
                                                  placeholder="email1@example.com, email2@example.com"><?php echo htmlspecialchars($config['recipient_emails'] ?? ''); ?></textarea>
                                    </div>
                                    <div class="row m-t-lg">
                                        <div class="col-md-6">
                                            <button type="button" id="testMailBtn" class="btn btn-info btn-lg btn-block">
                                                <i class="fa fa-paper-plane m-r-xs"></i> Send Test Email
                                            </button>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-success btn-lg btn-block">
                                                <i class="fa fa-save m-r-xs"></i> Save Configuration
                                            </button>
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

    <?php include 'js.php'; ?>
    <script>
    $(document).ready(function() {
        function toggleSections() {
            var provider = $('#email_provider').val();
            if (provider === 'mailersend_api') {
                $('#smtp_section').hide();
                $('#mailersend_api_section').show();
            } else {
                $('#mailersend_api_section').hide();
                $('#smtp_section').show();
            }
        }

        $('#email_provider').on('change', toggleSections);
        toggleSections(); // run on load

        function setupPasswordToggle(btnId, inputId) {
            $(btnId).on('click', function() {
                var input = $(inputId);
                var icon = $(this).find('i');
                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
        }

        setupPasswordToggle('#togglePassword', '#smtp_password');
        setupPasswordToggle('#toggleApiToken', '#mailersend_api_token');

        $('#testMailBtn').on('click', function() {
            var btn = $(this);
            var form = $('#smtpForm');
            var resultDiv = $('#testResult');
            
            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Testing...');
            resultDiv.hide().removeClass('alert-success alert-danger').addClass('alert-info').text('Testing connection, please wait...');
            resultDiv.show();

            $.ajax({
                url: 'email_config.php?action=test',
                type: 'POST',
                data: form.serialize(),
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        resultDiv.removeClass('alert-info alert-danger').addClass('alert-success').text(res.message);
                    } else {
                        resultDiv.removeClass('alert-info alert-success').addClass('alert-danger').text(res.error);
                    }
                    btn.prop('disabled', false).html('<i class="fa fa-paper-plane m-r-xs"></i> Send Test Email');
                },
                error: function() {
                    resultDiv.removeClass('alert-info alert-success').addClass('alert-danger').text('Server error while testing connection.');
                    btn.prop('disabled', false).html('<i class="fa fa-paper-plane m-r-xs"></i> Send Test Email');
                }
            });
        });
    });
    </script>
</body>
</html>
