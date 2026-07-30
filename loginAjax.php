<?php
error_reporting(E_ERROR);
include 'db.php';
include __DIR__ . '/session_init.php';

$status = '';
$error='';

if (empty($_POST['email']) || empty($_POST['password'])) {
$error = "Login ID or Password is invalid";
error_log("[LOGIN_AJAX] validation failed: email=" . ($_POST['email'] ?? '') . " pwlen=" . strlen($_POST['password'] ?? ''));
}
else
{
$email=$_POST['email'];
$password=$_POST['password'];

	$sql = "select * from tolly_user a where a.email = '$email' and a.password ='$password'";
	$result = mysqli_query ( $conn, $sql );	 
	if (mysqli_num_rows ( $result ) > 0) {
	$row = mysqli_fetch_assoc($result);
	
	$_SESSION["s_uid"] = $row["uid"];
	$_SESSION["s_user"] = $row["username"];
	$_SESSION["s_email"] = $row["email"];
	$_SESSION['s_pic'] = $row["pic"];
	$_SESSION['s_banner'] = $row["banner"];
	$_SESSION['s_type'] = $row["utype"];
	$_SESSION['s_rs'] = 0;
	
	$status = $row["status"];
	$status='active';
	
	error_log("[LOGIN_AJAX] SUCCESS uid={$row['uid']} user={$row['username']} status=$status sid=" . session_id() . " sess_keys=" . implode(',', array_keys($_SESSION)));
	
	if($status=='active')
	{	
	$error = "Login Success";
	}else{
		$error = "Your Account is Pending, Please check your mail and Click Link to Activate";
	}
	
} else {
$error = "User Not Found <a href='register.php'><h2>Signup Here</h2></a>";
error_log("[LOGIN_AJAX] FAIL no user match for email=$email");
}

if($conn!=null){
mysqli_close($conn);
}
}

session_write_close();
error_log("[LOGIN_AJAX] response: st=$status e=$error sid=" . session_id());
$arr = array('st' => $status, 'e' => $error, 'sql' =>'SQL IS '.$sql);
echo json_encode($arr);
?>