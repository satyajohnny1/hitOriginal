<?php
include 'db.php';
session_start();

$uid =  $_SESSION['s_uid'];
$s_bal = $_SESSION['s_bal'];
$title = $_GET ["_title_id"];
$budget = $_GET ["_budget_id"];
$sofar =  $_GET ["_sofar"];   

$bnr = $_SESSION['s_banner'];
$prod =$_SESSION["s_user"];


$did = $_GET ["_dir_id"];
$dname = $_GET ["_dir_name"];

$aid = $_GET ["_act_id"];
$aname = $_GET ["_act_name"];

$acid = $_GET ["_actress_id"];
$acname = $_GET ["_actress_name"];

$wid = $_GET ["_writer_id"];
$wname = $_GET ["_writer_name"];


$cid = $_GET ["_cine_id"];
$cname = $_GET ["_cine_name"];

$mid = $_GET ["_mus_id"];
$mname = $_GET ["_mus_name"];

$eid = $_GET ["_edi_id"];
$ename = $_GET ["_edi_name"];

$_a2 = $_GET ["_a2"];
$_a3 = $_GET ["_a3"];
$_ac2 = $_GET ["_ac2"];
$_ac3 = $_GET ["_ac3"];
$_w2 = $_GET ["_w2"];
$_w3 = $_GET ["_w3"];
$_m2 = $_GET ["_m2"];
$_m3 = $_GET ["_m3"];
$_d2 = $_GET ["_d2"];
$_d3 = $_GET ["_d3"];


$_a2_name = $_GET ["_a2_name"];
$_a3_name = $_GET ["_a3_name"];
$_ac2_name = $_GET ["_ac2_name"];
$_ac3_name = $_GET ["_ac3_name"];
$_w2_name = $_GET ["_w2_name"];
$_w3_name = $_GET ["_w3_name"];
$_m2_name = $_GET ["_m2_name"];
$_m3_name = $_GET ["_m3_name"];
$_d2_name = $_GET ["_d2_name"];
$_d3_name = $_GET ["_d3_name"];

 

 if($budget>400000001)
{
	$grade = "X";	
}
else if (250000000>$budget && $budget>400000000){
	
	$grade = "A";
}

else if (150000000>$budget && $budget>250000000){

	$grade = "B";
}

else if (100000000>$budget && $budget>150000000){

	$grade = "C";
}
else if (50000000>$budget && $budget>100000000){

	$grade = "D";
}


 else{
	
	$grade = "E";
}
	
	$sql = "INSERT INTO tolly_ready_for_shoot (uid, title, aid, acid, did, wid, mid, eid, cid, 
budget, sofar, grade, status, pic, dt,notes, dname, aname, acname,cinename, ediname, musname, wriname,progress,a2,a3,ac2,ac3,d2,d3,w2,w3,m2,m3,a2_name,a3_name,ac2_name,ac3_name,d2_name,d3_name,w2_name,w3_name,m2_name,m3_name) VALUES (".$uid.", '".$title."', ".$aid.", ".$acid.", ".$did.", ".$wid.", ".$mid.", ".$eid.", ".$cid.", ".$budget.", ".$sofar.", '".$grade."', 'ready','pic',CURDATE(),'-- NOTES--', '".$dname."', '".$aname."', '".$acname."', '".$cname."', '".$ename."', '".$mname."', '".$wname."',30
		, ".$_a2.", ".$_a3.", ".$_ac2.", ".$_ac3.", ".$_d2.",".$_d3.", ".$_w2.", ".$_w3.", ".$_m2.", ".$_m3.", '".$_a2_name."', '".$_a3_name."', '".$_ac2_name."', '".$_ac3_name."', '".$_d2_name."','".$_d3_name."', '".$_w2_name."', '".$_w3_name."', '".$_m2_name."', '".$_m3_name."')"; 
	
echo "<br> <br> <hr>";	
echo  $sql;
echo "<br> <br> <hr>";
$newbal = $s_bal - $sofar;


if (mysqli_query($conn, $sql)) {
	
	$q1 = "UPDATE tolly_user SET bal=".$newbal." WHERE  uid=".$uid;
	mysqli_query($conn, $q1);
	
		
	$unit = (($budget-$sofar)/9);
	
	$s1_a = round($unit+(rand(($unit*(10/100)), ($unit*(20/100))))-(rand(($unit*(10/100)), ($unit*(20/100)))));
	$s2_a = round($unit+(rand(($unit*(10/100)), ($unit*(20/100))))-(rand(($unit*(10/100)), ($unit*(20/100)))));
	$s3_a = round($unit+(rand(($unit*(10/100)), ($unit*(20/100))))-(rand(($unit*(10/100)), ($unit*(20/100)))));
	$s4_a = round($unit+(rand(($unit*(10/100)), ($unit*(20/100))))-(rand(($unit*(10/100)), ($unit*(20/100)))));
	$s5_a = round($unit+(rand(($unit*(10/100)), ($unit*(20/100))))-(rand(($unit*(10/100)), ($unit*(20/100)))));
	$s6_a = round($unit+(rand(($unit*(10/100)), ($unit*(20/100))))-(rand(($unit*(10/100)), ($unit*(20/100)))));
	$s7_a = round($unit+(rand(($unit*(10/100)), ($unit*(20/100))))-(rand(($unit*(10/100)), ($unit*(20/100)))));
	$s8_a = round($unit+(rand(($unit*(10/100)), ($unit*(20/100))))-(rand(($unit*(10/100)), ($unit*(20/100)))));
	$s9_a = round($unit+(rand(($unit*(10/100)), ($unit*(20/100))))-(rand(($unit*(10/100)), ($unit*(20/100)))));
	
	
	$s1_b = round(2*$s1_a+(rand((2*$s1_a*(10/100)), (2*$s1_a*(20/100))))-(rand((2*$s1_a*(10/100)), (2*$s1_a*(20/100)))));
	$s2_b = round(2*$s2_a+(rand((2*$s1_a*(10/100)), (2*$s1_a*(20/100))))-(rand((2*$s1_a*(10/100)), (2*$s1_a*(20/100)))));
	$s3_b = round(2*$s3_a+(rand((2*$s1_a*(10/100)), (2*$s1_a*(20/100))))-(rand((2*$s1_a*(10/100)), (2*$s1_a*(20/100)))));
	$s4_b = round(2*$s4_a+(rand((2*$s1_a*(10/100)), (2*$s1_a*(20/100))))-(rand((2*$s1_a*(10/100)), (2*$s1_a*(20/100)))));
	$s5_b = round(2*$s5_a+(rand((2*$s1_a*(10/100)), (2*$s1_a*(20/100))))-(rand((2*$s1_a*(10/100)), (2*$s1_a*(20/100)))));
	$s6_b = round(2*$s6_a+(rand((2*$s1_a*(10/100)), (2*$s1_a*(20/100))))-(rand((2*$s1_a*(10/100)), (2*$s1_a*(20/100)))));
	$s7_b = round(2*$s7_a+(rand((2*$s1_a*(10/100)), (2*$s1_a*(20/100))))-(rand((2*$s1_a*(10/100)), (2*$s1_a*(20/100)))));
	$s8_b = round(2*$s8_a+(rand((2*$s1_a*(10/100)), (2*$s1_a*(20/100))))-(rand((2*$s1_a*(10/100)), (2*$s1_a*(20/100)))));
	$s9_b = round(2*$s9_a+(rand((2*$s1_a*(10/100)), (2*$s1_a*(20/100))))-(rand((2*$s1_a*(10/100)), (2*$s1_a*(20/100)))));
	
	
	$s1_c = round(3.5*$s1_a+(rand((3.5*$s1_a*(10/100)), (3.5*$s1_a*(20/100))))-(rand((3.5*$s1_a*(10/100)), (3.5*$s1_a*(20/100)))));
	$s2_c = round(3.5*$s2_a+(rand((3.5*$s1_a*(10/100)), (3.5*$s1_a*(20/100))))-(rand((3.5*$s1_a*(10/100)), (3.5*$s1_a*(20/100)))));
	$s3_c = round(3.5*$s3_a+(rand((3.5*$s1_a*(10/100)), (3.5*$s1_a*(20/100))))-(rand((3.5*$s1_a*(10/100)), (3.5*$s1_a*(20/100)))));
	$s4_c = round(3.5*$s4_a+(rand((3.5*$s1_a*(10/100)), (3.5*$s1_a*(20/100))))-(rand((3.5*$s1_a*(10/100)), (3.5*$s1_a*(20/100)))));
	$s5_c = round(3.5*$s5_a+(rand((3.5*$s1_a*(10/100)), (3.5*$s1_a*(20/100))))-(rand((3.5*$s1_a*(10/100)), (3.5*$s1_a*(20/100)))));
	$s6_c = round(3.5*$s6_a+(rand((3.5*$s1_a*(10/100)), (3.5*$s1_a*(20/100))))-(rand((3.5*$s1_a*(10/100)), (3.5*$s1_a*(20/100)))));
	$s7_c = round(3.5*$s7_a+(rand((3.5*$s1_a*(10/100)), (3.5*$s1_a*(20/100))))-(rand((3.5*$s1_a*(10/100)), (3.5*$s1_a*(20/100)))));
	$s8_c = round(3.5*$s8_a+(rand((3.5*$s1_a*(10/100)), (3.5*$s1_a*(20/100))))-(rand((3.5*$s1_a*(10/100)), (3.5*$s1_a*(20/100)))));
	$s9_c = round(3.5*$s9_a+(rand((3.5*$s1_a*(10/100)), (3.5*$s1_a*(20/100))))-(rand((3.5*$s1_a*(10/100)), (3.5*$s1_a*(20/100)))));
		
	$cost = $s1_a+$s2_a+$s3_a+$s4_a+$s5_a+$s6_a+$s7_a+$s8_a+$s9_a;
	
	echo  "<br>";
echo  $s1_a."<br>";
echo  $s1_b."<br>";
echo  $s1_c."<br>";
echo  "<h1>".$cost."</h1>";
$q = "SELECT * FROM tolly_ready_for_shoot r WHERE r.uid = ".$uid." AND r.title = '".$title."'";
echo "<br><br>----------------------<br>".$q;
$result = mysqli_query($conn, $q); 
if (mysqli_num_rows($result) > 0) {	
	$row = mysqli_fetch_assoc($result);
		$rid = $row["rid"];
$s1 = "INSERT INTO tolly_s1 (sid,uid, s1_a_cost, s1_b_cost, s1_c_cost) VALUES (".$rid.", ".$uid.", ".$s1_a.", ".$s1_b.", ".$s1_c.")";
mysqli_query($conn, $s1);
echo "<br><br>----------------------<br>".$s1;


$s1 = "INSERT INTO tolly_s2 (sid,uid, s2_a_cost, s2_b_cost, s2_c_cost) VALUES (".$rid.", ".$uid.", ".$s2_a.", ".$s2_b.", ".$s2_c.")";
mysqli_query($conn, $s1);
echo "<br><br>----------------------<br>".$s1;

$s1 = "INSERT INTO tolly_s3 (sid,uid, s3_a_cost, s3_b_cost, s3_c_cost) VALUES (".$rid.", ".$uid.", ".$s3_a.", ".$s3_b.", ".$s3_c.")";
mysqli_query($conn, $s1);
echo "<br><br>----------------------<br>".$s1;

$s1 = "INSERT INTO tolly_s4 (sid,uid, s4_a_cost, s4_b_cost, s4_c_cost) VALUES (".$rid.", ".$uid.", ".$s4_a.", ".$s4_b.", ".$s4_c.")";
mysqli_query($conn, $s1);
echo "<br><br>----------------------<br>".$s1;

$s1 = "INSERT INTO tolly_s5 (sid,uid, s5_a_cost, s5_b_cost, s5_c_cost) VALUES (".$rid.", ".$uid.", ".$s5_a.", ".$s5_b.", ".$s5_c.")";
mysqli_query($conn, $s1);
echo "<br><br>----------------------<br>".$s1;

$s1 = "INSERT INTO tolly_s6 (sid,uid, s6_a_cost, s6_b_cost, s6_c_cost) VALUES (".$rid.", ".$uid.", ".$s6_a.", ".$s6_b.", ".$s6_c.")";
mysqli_query($conn, $s1);
echo "<br><br>----------------------<br>".$s1;

$s1 = "INSERT INTO tolly_s7 (sid,uid, s7_a_cost, s7_b_cost, s7_c_cost) VALUES (".$rid.", ".$uid.", ".$s7_a.", ".$s7_b.", ".$s7_c.")";
mysqli_query($conn, $s1);
echo "<br><br>----------------------<br>".$s1;

$s1 = "INSERT INTO tolly_s8 (sid,uid, s8_a_cost, s8_b_cost, s8_c_cost) VALUES (".$rid.", ".$uid.", ".$s8_a.", ".$s8_b.", ".$s8_c.")";
mysqli_query($conn, $s1);
echo "<br><br>----------------------<br>".$s1;




$s1 = "INSERT INTO tolly_s9 (sid,uid, s9_a_cost, s9_b_cost, s9_c_cost) VALUES (".$rid.", ".$uid.", ".$s9_a.", ".$s9_b.", ".$s9_c.")";
mysqli_query($conn, $s1);


$news = "New Movie is announced!! <b>".$title."</b>, with <a href=\'actor.php?id=$aid\'>".$aname."</a> Direction by <a href=\'director.php?id=$did\'>". $dname."</a>,
 Producing by ".$bnr." and Producer is ".$prod;


$sql3 = "INSERT INTO  `tolly_news` (`news`, `heading`) VALUES ('".$news."', 'New Movie Casting')";
echo 'News ----> '.$sql3;
mysqli_query($conn, $sql3);



header('Location: readyforshoot.php');
	
}

} else {
	echo "<a href= 'logout.php' style='color: red'>Error:<br><br><br> " . $sql . "<br><br><br>" . mysqli_error($conn)."</a>" ;

}
  
?>
 