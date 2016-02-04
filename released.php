<?php
include 'sessionCheck.php'; 
error_reporting(0);
include 'db.php';
include 'balance.php';
session_start(); 

date_default_timezone_set("America/New_York");
$rel_date = date("Y-m-d h:i:s"); 
echo "<br><br>Time " . $rel_date;


$uid =  $_SESSION['s_uid'];
$rid =  $_GET ["rid"];


$q1 = "UPDATE tolly_ready_for_shoot SET status='running' WHERE  rid=".$rid." and uid=".$uid;
echo $q1;
mysqli_query($conn, $q1);

$q2 = "UPDATE tolly_release SET rel_date= '".$rel_date."' ,  status='running' WHERE  rid=".$rid." and uid=".$uid;
echo $q2;
mysqli_query($conn, $q2);



$news =    $_GET ["news"];
echo "News ".$news;
echo "INSERT INTO  `tolly_news` (`news`, `heading`) VALUES ('".$news."', 'New Release')";
mysqli_query($conn, "INSERT INTO  `tolly_news` (`news`, `heading`) VALUES ('".$news."', 'New Release')");



header('Location: readyforrun.php?rid='.$rid);
?>