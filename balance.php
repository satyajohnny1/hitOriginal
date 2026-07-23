<?php
include 'db.php';
error_reporting(0);
$s_uid = isset($_SESSION["s_uid"]) ? (int)$_SESSION["s_uid"] : 0;
if ($s_uid > 0) {
	// SQL query to fetch information of registered users and finds user match.
	$sql = "select TRIM(u.bal) as bal from tolly_user u WHERE u.uid = " . $s_uid;
	//echo $sql;	
	$result = mysqli_query ( $conn, $sql );	 
	if ($result && mysqli_num_rows ( $result ) > 0) {
		$row = mysqli_fetch_assoc($result);
		$s_bal = $row["bal"];	 
		
		$s_rs = round(($s_bal/10000000),2).'Cr';
		$_SESSION['s_bal'] =$s_bal; 
		$_SESSION['s_rs'] =$s_rs;
		echo $s_bal;
	}
}
?>