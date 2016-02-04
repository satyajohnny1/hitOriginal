<?php
include 'db.php';
error_reporting(0);
$s_uid = 0;
$s_uid = $_SESSION["s_uid"];
//echo  "USER ID  : ".$s_uid;
 // SQL query to fetch information of registerd users and finds user match.
	$sql = "select TRIM(u.bal) as bal from tolly_user u WHERE u.uid =".$s_uid;
	//echo $sql;	
	$result = mysqli_query ( $conn, $sql );	 
	if (mysqli_num_rows ( $result ) > 0) {
	$row = mysqli_fetch_assoc($result);
	$s_bal = $row["bal"];	 
	
	$s_rs = round(($s_bal/10000000),2).'Cr';
	 $_SESSION['s_bal'] =$s_bal; 
	 $_SESSION['s_rs'] =$s_rs;
	 echo $s_bal;
	}

?>