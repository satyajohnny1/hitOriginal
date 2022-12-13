<?php
error_reporting(E_ERROR);
include 'db.php';
session_start(); // Starting Session

 
$rid= $_GET['id'];
$uid =  $_SESSION['s_uid'];
$bal = $_SESSION['s_bal']; 
 



$sql = "SELECT * from tolly_release   WHERE  rid=".$rid;
$result = mysqli_query($conn, $sql);
 
if (mysqli_num_rows($result) > 0) {
	// output data of each row
	if($row = mysqli_fetch_assoc($result)) {
		
		
		
		$rel_cen     =	$row["rel_cen"];
		$wk1_cen     =	$row["1w_cen"];
		$wk2_cen     =	$row["2w_cen"];
		$d25_cen     =	$row["25d_cen"];
		$d50_cen     =	$row["50d_cen"];
		$d75_cen     =	$row["75d_cen"];
		$d100_cen    =	$row["100d_cen"];
		$d125_cen    =	$row["125d_cen"];
		$d150_cen    =	$row["150d_cen"];
		$d175_cen    =	$row["175d_cen"];
		$wk1_coll     =	$row["1w_coll"];
		$wk2_coll     =	$row["2w_coll"];
		$d25_coll     =	$row["25d_coll"];
		$d50_coll     =	$row["50d_coll"];
		$d75_coll     =	$row["75d_coll"];
		$d100_coll    =	$row["100d_coll"];
		$d125_coll    =	$row["125d_coll"];
		$d150_coll    =	$row["150d_coll"];
		$d175_coll    =	$row["175d_coll"];
		$max_days     =	$row["max_days"];
		$max_coll     =	$row["total_coll"];
		$stat     =	$row["status"];
		
	}
}

 


	$q1 = "UPDATE tolly_ready_for_shoot SET status='out' WHERE  rid=".$rid." and uid=".$uid;
	mysqli_query($conn, $q1);
	echo "<br>Done : ".$q1;
	
	$q2 = "UPDATE tolly_release SET status='out' WHERE  rid=".$rid." and uid=".$uid;
	mysqli_query($conn, $q2);
	echo "<br>Done : ".$q2;
	
	$newbal = round(floatval($bal)+floatval($max_coll));
	$sql = "UPDATE tolly_user SET bal=".$newbal." WHERE  uid= ".$uid;
	mysqli_query($conn, $sql);
	echo "<br>Done : ".$sql;

 
	echo "<h1><a href=\"readyforrun.php\"> Go Back </a>";
        echo "<h1><a href='movie.php?rid=".$rid."' class='btn btn-danger btn-rounded'>Go to Movie</a></h1>";
 
 
if($conn!=null){
mysqli_close($conn);
} // Closing Connection
 
?>
