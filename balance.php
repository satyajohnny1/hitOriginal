<?php
include 'db.php';
error_reporting(0);
$s_uid = isset($_SESSION["s_uid"]) ? (int)$_SESSION["s_uid"] : 0;
if ($s_uid > 0) {
	$sql = "select TRIM(u.bal) as bal, TRIM(u.debt) as debt from tolly_user u WHERE u.uid = " . $s_uid;
	$result = mysqli_query ( $conn, $sql );	 
	if ($result && mysqli_num_rows ( $result ) > 0) {
		$row = mysqli_fetch_assoc($result);
		$s_bal = $row["bal"];
		$s_debt = $row["debt"];

		$s_rs = round(($s_bal/10000000),2).'Cr';
		$s_debt_rs = round(($s_debt/10000000),2).'Cr';
		$_SESSION['s_bal'] =$s_bal;
		$_SESSION['s_rs'] =$s_rs;
		$_SESSION['s_debt'] = $s_debt;
		$_SESSION['s_debt_rs'] = $s_debt_rs;
		echo $s_bal;
	}
}
?>