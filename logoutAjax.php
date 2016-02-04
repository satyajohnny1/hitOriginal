<?php
if(isset($_SESSION['login_user'])){
	unset($_SESSION['login_user']);  //Is Used To Destroy Specified Session
}
session_destroy(); // Is Used To Destroy All Sessions
header("location: login.php");


?>