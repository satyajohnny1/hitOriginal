<?php
//error_reporting(0);
include 'db.php';
include 'balance.php';
session_start(); 
$uid =  $_SESSION['s_uid'];
$bal = $_SESSION['s_bal'];
$max_coll = rand(100000,10000000);

$newbal = round(floatval($bal)+floatval($max_coll));
$sql = "UPDATE tolly_user SET bal=".$newbal." WHERE  uid= ".$uid;
 
//echo $sql;
mysqli_query($conn, $sql);
$arr = array('a' => $max_coll);
echo json_encode($arr);

?>