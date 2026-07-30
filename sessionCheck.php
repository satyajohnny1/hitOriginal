<?php
// Start the session
 error_reporting(E_ERROR);
include __DIR__ . '/session_init.php';
if(!isset($_SESSION['s_uid'])) {
error_log("[SESSCHK] NO uid in session. sid=" . session_id() . " keys=" . implode(',', array_keys($_SESSION)));
header("location: login.php?sess=notlogin-or-session-Expired ");
exit;
}
error_log("[SESSCHK] OK uid={$_SESSION['s_uid']} sid=" . session_id());
?>

 