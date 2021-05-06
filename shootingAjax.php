<?php
error_reporting(E_ERROR);
include 'db.php';
session_start(); // Starting Session

$a = 0;
$b=0; 
$c = 0;

$s=$_GET['s'];
$rid=$_GET['rid'];
// Establishing Connection with Server by passing server_name, user_id and password as a parameter


// SQL query to fetch information of registerd users and finds user match.
 $sql = "SELECT * FROM tolly_".$s." s WHERE s.sid = ".$rid;
 //echo $sql;
 $result = mysqli_query ( $conn, $sql ); 
 if (mysqli_num_rows ( $result ) > 0) {
 $row = mysqli_fetch_assoc($result);
 global $a,$b,$c;
 $a1 = $row[$s."_a_rate"];
 $b1 = $row[$s."_b_rate"];
 $c1 = $row[$s."_c_rate"];
 
 //echo $sql;
 //echo "a :  ".$a1." b:  ".$b1."  c: ".$c1;
 
 if($a1!=null)
 {
 	$a=1;
 }
 
 if($b1!=null)
 {
 	$b=1;
 }
 
 
 if($c1!=null)
 {
 	$c=1;
 }
 

  
} 

mysqli_close($conn); // Closing Connection

$arr = array('a' => $a, 'b' => $b, 'c' => $c);
echo json_encode($arr);
?>