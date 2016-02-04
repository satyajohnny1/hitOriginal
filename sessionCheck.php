<?php
// Start the session
 error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION['s_uid'])) {
//echo 'Session Expired, or Your Not Login';
header("location: login.php?sess=notlogin-or-session-Expired ");
}
?>

 