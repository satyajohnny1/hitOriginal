<?php
error_reporting(E_ERROR);
include 'db.php';
session_start();
$uid = $_SESSION['s_uid'];

$countJson = '';


// ********** HIT and Fut % ******************
	$sql = "select count(*) as cnt, s.result from tolly_ready_for_shoot s WHERE s.uid = ".$uid." and s.`status` = 'out' GROUP BY s.result";
	//echo '<h2>'.$sql.'</h2>';
	$result = mysqli_query ( $conn, $sql );	 
	if (mysqli_num_rows($result) > 0) {
 		while($row = mysqli_fetch_assoc($result)) {
	$row = mysqli_fetch_assoc($result);
	
 	$countJson = "['"+$row['cnt']."', '".$row['result']."'],";
 		}
	}

 
 
if($conn!=null){
mysqli_close($conn);
}
 // Closing Connection
echo $countJson;


$arr = array('countJson' => $countJson);
echo json_encode($arr);


?>