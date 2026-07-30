<?php
include __DIR__ . '/session_init.php';
error_log("[LOGOUT] s_uid=" . ($_SESSION['s_uid'] ?? 'NOT_SET') . " sid=" . session_id());
if(isset($_SESSION['s_uid'])){
	unset($_SESSION['s_uid']);
}
session_destroy();
header("location: login.php");


?>