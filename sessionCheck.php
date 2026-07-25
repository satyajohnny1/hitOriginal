<?php
// Start the session
 error_reporting(E_ERROR);
include __DIR__ . '/session_init.php';
if(!isset($_SESSION['s_uid'])) {
//echo 'Session Expired, or Your Not Login';
header("location: login.php?sess=notlogin-or-session-Expired ");
exit;
}
?>

 