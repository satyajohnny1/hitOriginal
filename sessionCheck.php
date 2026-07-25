<?php
// Start the session
 error_reporting(E_ERROR);
$cookie_lifetime = 48 * 60 * 60; // 48 hours
ini_set('session.gc_maxlifetime', $cookie_lifetime);
session_set_cookie_params($cookie_lifetime);
session_start();
if(!isset($_SESSION['s_uid'])) {
//echo 'Session Expired, or Your Not Login';
header("location: login.php?sess=notlogin-or-session-Expired ");
exit;
}
?>

 