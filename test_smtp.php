<?php
declare(strict_types=1);
include 'sessionCheck.php';
include 'db.php';
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Fetch SMTP credentials
$configRes = mysqli_query($conn, "SELECT * FROM `tolly_email_config` WHERE `id` = 1");
$config = mysqli_fetch_assoc($configRes);

if (!$config) {
    die("No configuration found in database.");
}

$host = $config['smtp_host'];
$port = (int)$config['smtp_port'];
$username = $config['smtp_username'];
$password = $config['smtp_password'];
$secure = $config['smtp_secure'];
$fromEmail = $config['from_email'];
$recipient = $config['recipient_emails'];

echo "<h3>SMTP Verbose Diagnostic Trace</h3>";
echo "<pre>";
echo "Connecting to $host:$port (Security: $secure)...\n";

$socketHost = $host;
if ($secure === 'ssl') {
    $socketHost = 'ssl://' . $host;
}

$socket = fsockopen($socketHost, $port, $errno, $errstr, 15);
if (!$socket) {
    die("Connection failed: $errstr ($errno)\n");
}

function readTrace($socket) {
    $response = '';
    while ($line = fgets($socket, 515)) {
        echo "&lt; " . htmlspecialchars($line);
        $response .= $line;
        if (substr($line, 3, 1) === ' ') {
            break;
        }
    }
    return $response;
}

function sendTrace($socket, $cmd) {
    echo "&gt; " . htmlspecialchars($cmd) . "\n";
    fwrite($socket, $cmd . "\r\n");
}

readTrace($socket);
sendTrace($socket, "EHLO localhost");
readTrace($socket);

if ($secure === 'tls') {
    sendTrace($socket, "STARTTLS");
    readTrace($socket);
    echo "Starting TLS crypto tunnel...\n";
    if (!stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
        die("TLS crypto handshake failed.\n");
    }
    echo "TLS crypto tunnel established successfully.\n";
    sendTrace($socket, "EHLO localhost");
    readTrace($socket);
}

if (!empty($username)) {
    echo "Attempting AUTH LOGIN...\n";
    sendTrace($socket, "AUTH LOGIN");
    readTrace($socket);
    
    sendTrace($socket, base64_encode($username));
    readTrace($socket);
    
    sendTrace($socket, base64_encode($password));
    readTrace($socket);
}

sendTrace($socket, "QUIT");
readTrace($socket);
fclose($socket);
echo "Connection closed.\n";
echo "</pre>";
?>
