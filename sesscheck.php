<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include __DIR__ . '/session_init.php';
header('Content-Type: text/plain');
echo "SESSION STARTED: " . (session_status() === PHP_SESSION_ACTIVE ? 'YES' : 'NO') . "\n";
echo "SESSION ID: " . session_id() . "\n";
echo "COOKIE: " . ($_COOKIE['PHPSESSID'] ?? 'NOT SET') . "\n\n";
echo "SESSION KEYS:\n";
foreach ($_SESSION as $k => $v) {
    echo "  $k => " . (is_scalar($v) ? $v : json_encode($v)) . "\n";
}
echo "\nSERVER vars:\n";
echo "  HTTP_HOST: " . ($_SERVER['HTTP_HOST'] ?? 'N/A') . "\n";
echo "  REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'N/A') . "\n";
echo "  HTTPS: " . ($_SERVER['HTTPS'] ?? 'N/A') . "\n";
