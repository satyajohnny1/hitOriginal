<?php
 error_reporting(E_ERROR);
include __DIR__ . '/session_init.php';
if(!isset($_SESSION['s_uid'])) {
error_log("[SESSCHK] BLOCKED sid=" . session_id() . " cookie=" . ($_COOKIE['PHPSESSID'] ?? 'NO_COOKIE') . " keys=" . implode(',', array_keys($_SESSION)) . " uri=" . ($_SERVER['REQUEST_URI'] ?? 'n/a'));
header("location: login.php?sess=notlogin-or-session-Expired ");
exit;
}
error_log("[SESSCHK] PASS uid={$_SESSION['s_uid']} user={$_SESSION['s_user']} sid=" . session_id() . " uri=" . ($_SERVER['REQUEST_URI'] ?? 'n/a'));
?>

 