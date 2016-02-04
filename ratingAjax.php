<?php
error_reporting(0);
include 'db.php';

session_start(); 
//uid,bal,rid,sofar,s,s1_a_rate,s1_status

$sid = $_GET ["rid"];
$now = $_GET ["now"];
$sofar = 0;
$uid =  $_SESSION['s_uid'];
$s_bal =  0;
$a = 0;
$b = 0;
$chose = $_GET ["now"];
$progress = 0;

//$rate = mt_rand (1*10, 10*10) / 10 ;
////echo $rate;

if (strpos($chose,'_c') !== false) {
	$rate = mt_rand (4*10, 10*10) / 10 ;
	//echo 'in C'.$rate;
}

else if (strpos($chose,'_b') !== false) {
	$rate = mt_rand (2.5*10, 10*10) / 10 ;
	//echo 'in B'.$rate;
}

else  {
	$rate = mt_rand (1*10, 10*10) / 10 ;
	//echo 'in A'.$rate;
}

$best = $rate;
$sql = "select TRIM(u.bal) as bal from tolly_user u WHERE u.uid =".$uid;
//echo $sql;
$result = mysqli_query ( $conn, $sql );
if (mysqli_num_rows ( $result ) > 0) {
	$row = mysqli_fetch_assoc($result);
	$s_bal = $row["bal"];
	$_SESSION['s_bal'] =$s_bal;
	//echo $s_bal;
}




$sql = "select * from tolly_ready_for_shoot r WHERE r.uid = ".$uid." and r.rid = ".$sid ;
//echo $sql;
$result = mysqli_query ( $conn, $sql );
if (mysqli_num_rows ( $result ) > 0) {
	$row = mysqli_fetch_assoc($result);
	$sofar = $row["sofar"];	
	$progress = $row["progress"];
}

//echo 'SO Far From DB : '.$sofar;


//$s_bal      s1_a_cost=1000
//----------------------------------------------------------s1 logics---------------------------
if (strcasecmp($now, 's1_a') == 0) {
	//echo 'IN S5*********************';
	//Update SOFAR
	$newsofar = $_GET ["s1_a_cost"]+$sofar;
	
	//echo $_GET ["s1_a_cost"].'New Sofar Far From DB : '.$newsofar;
	
	//Update BALANCE
	$newbal = $s_bal-$_GET ["s1_a_cost"];
	
//echo $s_bal.'      -          '.$_GET ["s1_a_cost"];
	
	//Update STATUS
	$status = 's1_b';
	
	//get RATING 
	$rt = $rate;	

	$sql = "UPDATE tolly_user SET bal=".$newbal." WHERE  uid= ".$uid;
	mysqli_query($conn, $sql);	
	//echo $sql;
	
	$sql = "UPDATE tolly_ready_for_shoot SET progress=40, sofar=".$newsofar.", s='".$status."' WHERE  rid=".$sid." and uid= ".$uid;
	//echo  $sql;
	mysqli_query($conn, $sql);
	
	
	$sql = "UPDATE tolly_s1 SET s1_a_rate=".$rate.", s1_status='".$status."', s1_best=".$best."  WHERE  sid=".$sid." and uid= ".$uid;
	//echo  $sql;
	mysqli_query($conn, $sql);
	
	$arr = array('sofar' => $newsofar, 'bal' => $newbal, 'status' => $status, 'rate' => $rate);
	echo json_encode($arr);
	
}

else if (strcasecmp($now, 's1_b') == 0) {

	//Update SOFAR
	$newsofar = $_GET ["s1_a_cost"]+$sofar;



 

	//Update BALANCE
	$newbal = $s_bal-$_GET ["s1_b_cost"];

	//////echo $s_bal.'      -          '.$_GET ["s1_b_cost"];

	//Update STATUS
	$status = 's1_c';

//get RATING
	$rt = $rate;
	$a = $_GET ["s1_a_rate"];

	
	if($rt>$a && $rt>$b)
	{
		$best=$rt;
	}else if($a>$b && $a>$rt)
	{
		$best = $a;
	}else{
		$best = $b;
		
	}
	

	//echo $s1_b_cost;
	
	$sql = "UPDATE tolly_user SET bal=".$newbal." WHERE  uid= ".$uid;
	mysqli_query($conn, $sql);

	$sql = "UPDATE tolly_ready_for_shoot SET progress=40, sofar=".$newsofar.", s='".$status."'  WHERE  rid=".$sid." and uid= ".$uid;
	mysqli_query($conn, $sql);


	$sql = "UPDATE tolly_s1 SET s1_b_rate=".$rate.", s1_status='".$status."', s1_best=".$best."  WHERE sid=".$sid." and uid= ".$uid;
	//echo $sql;
	mysqli_query($conn, $sql);

	$arr = array('sofar' => $newsofar, 'bal' => $newbal, 'status' => $status, 'rate' => $rate);
	echo json_encode($arr);
}

else if (strcasecmp($now, 's1_c') == 0) {
	
	//Update SOFAR
	$newsofar = $_GET ["s1_c_cost"]+$sofar;
	
	//Update BALANCE
	$newbal = $s_bal-$_GET ["s1_c_cost"];
	
	//////echo $s_bal.'      -          '.$_GET ["s1_c_cost"];
	
	//Update STATUS
	$status = 's2_a';
	
//get RATING
	$rt = $rate;
	$a = $_GET ["s1_a_rate"];
	$b = $_GET ["s1_b_rate"];
	
	if($rt>$a && $rt>$b)
	{
		$best=$rt;
	}else if($a>$b && $a>$rt)
	{
		$best = $a;
	}else{
		$best = $b;
		
	}
	
	
	
	if($a>$rt)
	{
		$best=$a;
	}else{
		$best=$rt;
	}
	

	$sql = "UPDATE tolly_user SET bal=".$newbal." WHERE  uid= ".$uid;
	////echo '<h1>1 :   '.$sql.'</h1>';
	mysqli_query($conn, $sql);	
	
	$sql = "UPDATE tolly_ready_for_shoot SET progress=20, sofar=".$newsofar.", s='".$status."'  WHERE  rid=".$sid." and uid= ".$uid;
	////echo '<h1>2 :   '.$sql.'</h1>';
	mysqli_query($conn, $sql);
	
	
	$sql = "UPDATE tolly_s1 SET s1_c_rate=".$rate.", s1_status='".$status."', s1_best=".$best."  WHERE  sid=".$sid." and uid= ".$uid;
	////echo '<h1>3 :   '.$sql.'</h1>';
	mysqli_query($conn, $sql);
	
	$arr = array('sofar' => $newsofar, 'bal' => $newbal, 'status' => $status, 'rate' => $rate);
	echo json_encode($arr);
}//----------------------------------------------------------s2 logics---------------------------
else if (strcasecmp($now, 's2_a') == 0) {
	
	//Update SOFAR
	$newsofar = $_GET ["s2_a_cost"]+$sofar;
	
	//Update BALANCE
	$newbal = $s_bal-$_GET ["s2_a_cost"];
	
////echo $s_bal.'      -          '.$_GET ["s2_a_cost"];
	
	//Update STATUS
	$status = 's2_b';
	
	//get RATING 
	$rt = $rate;	

	$sql = "UPDATE tolly_user SET bal=".$newbal." WHERE  uid= ".$uid;
	mysqli_query($conn, $sql);	
	
	$sql = "UPDATE tolly_ready_for_shoot SET progress=50, sofar=".$newsofar.", s='".$status."' WHERE  rid=".$sid." and uid= ".$uid;
	//echo  $sql;
	mysqli_query($conn, $sql);
	
	
	$sql = "UPDATE tolly_s2 SET s2_a_rate=".$rate.", s2_status='".$status."', s2_best=".$best."  WHERE  sid=".$sid." and uid= ".$uid;
	mysqli_query($conn, $sql);
	
	$arr = array('sofar' => $newsofar, 'bal' => $newbal, 'status' => $status, 'rate' => $rate);
	echo json_encode($arr);
	
}

else if (strcasecmp($now, 's2_b') == 0) {

	//Update SOFAR
	$newsofar = $_GET ["s2_b_cost"]+$sofar;

	//Update BALANCE
	$newbal = $s_bal-$_GET ["s2_b_cost"];

	//////echo $s_bal.'      -          '.$_GET ["s2_b_cost"];

	//Update STATUS
	$status = 's2_c';

//get RATING
	$rt = $rate;
	$a = $_GET ["s2_a_rate"];
	
	
	if($rt>$a && $rt>$b)
	{
		$best=$rt;
	}else if($a>$b && $a>$rt)
	{
		$best = $a;
	}else{
		$best = $b;
		
	}

	$sql = "UPDATE tolly_user SET bal=".$newbal." WHERE  uid= ".$uid;
	mysqli_query($conn, $sql);

	$sql = "UPDATE tolly_ready_for_shoot SET progress=50, sofar=".$newsofar.", s='".$status."'  WHERE  rid=".$sid." and uid= ".$uid;
	mysqli_query($conn, $sql);


	$sql = "UPDATE tolly_s2 SET s2_b_rate=".$rate.", s2_status='".$status."', s2_best=".$best."   WHERE  sid=".$sid." and uid= ".$uid;
	mysqli_query($conn, $sql);

	$arr = array('sofar' => $newsofar, 'bal' => $newbal, 'status' => $status, 'rate' => $rate);
	echo json_encode($arr);
}

else if (strcasecmp($now, 's2_c') == 0) {
	
	//Update SOFAR
	$newsofar = $_GET ["s2_c_cost"]+$sofar;
	
	//Update BALANCE
	$newbal = $s_bal-$_GET ["s2_c_cost"];
	
	//////echo $s_bal.'      -          '.$_GET ["s2_c_cost"];
	
	//Update STATUS
	$status = 's3_a';
	
//get RATING
	$rt = $rate;
	$a = $_GET ["s2_a_rate"];
	$b = $_GET ["s2_b_rate"];
	
	if($rt>$a && $rt>$b)
	{
		$best=$rt;
	}else if($a>$b && $a>$rt)
	{
		$best = $a;
	}else{
		$best = $b;
		
	}	

	$sql = "UPDATE tolly_user SET bal=".$newbal." WHERE  uid= ".$uid;
	////echo '<h1>1 :   '.$sql.'</h1>';
	mysqli_query($conn, $sql);	
	
	$sql = "UPDATE tolly_ready_for_shoot SET progress=50, sofar=".$newsofar.", s='".$status."'  WHERE  rid=".$sid." and uid= ".$uid;
	////echo '<h1>2 :   '.$sql.'</h1>';
	mysqli_query($conn, $sql);
	
	
	$sql = "UPDATE tolly_s2 SET s2_c_rate=".$rate.", s2_status='".$status."', s2_best=".$best." WHERE  sid=".$sid." and uid= ".$uid;
	////echo '<h1>3 :   '.$sql.'</h1>';
	mysqli_query($conn, $sql);
	
	$arr = array('sofar' => $newsofar, 'bal' => $newbal, 'status' => $status, 'rate' => $rate);
	echo json_encode($arr);
}

//----------------------------------------------------s2 end -----------------------------------------




//----------------------------------------------------------s3 logics---------------------------
else if (strcasecmp($now, 's3_a') == 0) {
	
	//Update SOFAR
	$newsofar = $_GET ["s3_a_cost"]+$sofar;
	
	//Update BALANCE
	$newbal = $s_bal-$_GET ["s3_a_cost"];
	
////echo $s_bal.'      -          '.$_GET ["s3_a_cost"];
	
	//Update STATUS
	$status = 's3_b';
	
	//get RATING 
	$rt = $rate;	

	$sql = "UPDATE tolly_user SET bal=".$newbal." WHERE  uid= ".$uid;
	mysqli_query($conn, $sql);	
	
	$sql = "UPDATE tolly_ready_for_shoot SET progress=60, sofar=".$newsofar.", s='".$status."' WHERE  rid=".$sid." and uid= ".$uid;
	//echo  $sql;
	mysqli_query($conn, $sql);
	
	
	$sql = "UPDATE tolly_s3 SET s3_a_rate=".$rate.", s3_status='".$status."', s3_best=".$best."  WHERE  sid=".$sid." and uid= ".$uid;
	mysqli_query($conn, $sql);
	
	$arr = array('sofar' => $newsofar, 'bal' => $newbal, 'status' => $status, 'rate' => $rate);
	echo json_encode($arr);
	
}

else if (strcasecmp($now, 's3_b') == 0) {

	//Update SOFAR
	$newsofar = $_GET ["s3_b_cost"]+$sofar;

	//Update BALANCE
	$newbal = $s_bal-$_GET ["s3_b_cost"];

	//////echo $s_bal.'      -          '.$_GET ["s3_b_cost"];

	//Update STATUS
	$status = 's3_c';

//get RATING
	$rt = $rate;
	$a = $_GET ["s3_a_rate"];
	
	
	if($rt>$a && $rt>$b)
	{
		$best=$rt;
	}else if($a>$b && $a>$rt)
	{
		$best = $a;
	}else{
		$best = $b;
		
	}

	$sql = "UPDATE tolly_user SET bal=".$newbal." WHERE  uid= ".$uid;
	mysqli_query($conn, $sql);

	$sql = "UPDATE tolly_ready_for_shoot SET progress=60, sofar=".$newsofar.", s='".$status."'  WHERE  rid=".$sid." and uid= ".$uid;
	mysqli_query($conn, $sql);


	$sql = "UPDATE tolly_s3 SET s3_b_rate=".$rate.", s3_status='".$status."', s3_best=".$best."    WHERE  sid=".$sid." and uid= ".$uid;
	mysqli_query($conn, $sql);

	$arr = array('sofar' => $newsofar, 'bal' => $newbal, 'status' => $status, 'rate' => $rate);
	echo json_encode($arr);
}

else if (strcasecmp($now, 's3_c') == 0) {
	
	//Update SOFAR
	$newsofar = $_GET ["s3_c_cost"]+$sofar;
	
	//Update BALANCE
	$newbal = $s_bal-$_GET ["s3_c_cost"];
	
	//////echo $s_bal.'      -          '.$_GET ["s3_c_cost"];
	
	//Update STATUS
	$status = 's4_a';
	
//get RATING
	$rt = $rate;
	$a = $_GET ["s3_a_rate"];
	$b = $_GET ["s3_b_rate"];
	
	if($rt>$a && $rt>$b)
	{
		$best=$rt;
	}else if($a>$b && $a>$rt)
	{
		$best = $a;
	}else{
		$best = $b;
		
	}	

	$sql = "UPDATE tolly_user SET bal=".$newbal." WHERE  uid= ".$uid;
	//echo '<h1>1 :   '.$sql.'</h1>';
	mysqli_query($conn, $sql);	
	
	$sql = "UPDATE tolly_ready_for_shoot SET progress=65, sofar=".$newsofar.", s='".$status."'  WHERE  rid=".$sid." and uid= ".$uid;
	//echo '<h1>2 :   '.$sql.'</h1>';
	mysqli_query($conn, $sql);
	
	
	$sql = "UPDATE tolly_s3 SET s3_c_rate=".$rate.", s3_status='".$status."', s3_best=".$best." where  sid=".$sid." and uid= ".$uid;
	//echo '<h1>3 :   '.$sql.'</h1>';
	mysqli_query($conn, $sql);
	
	$arr = array('sofar' => $newsofar, 'bal' => $newbal, 'status' => $status, 'rate' => $rate);
	echo json_encode($arr);
}

//----------------------------------------------------s3 end -----------------------------------------


//----------------------------------------------------------s4 logics---------------------------
else if (strcasecmp($now, 's4_a') == 0) {
	
	//Update SOFAR
	$newsofar = $_GET ["s4_a_cost"]+$sofar;
	
	//Update BALANCE
	$newbal = $s_bal-$_GET ["s4_a_cost"];
	
////echo $s_bal.'      -          '.$_GET ["s4_a_cost"];
	
	//Update STATUS
	$status = 's4_b';
	
	

	$sql = "UPDATE tolly_user SET bal=".$newbal." WHERE  uid= ".$uid;
	mysqli_query($conn, $sql);	
	
	$sql = "UPDATE tolly_ready_for_shoot SET progress=65, sofar=".$newsofar.", s='".$status."' WHERE  rid=".$sid." and uid= ".$uid;
	//echo  $sql;
	mysqli_query($conn, $sql);
	
	
	$sql = "UPDATE tolly_s4 SET s4_a_rate=".$rate.", s4_status='".$status."', s4_best=".$best."  WHERE  sid=".$sid." and uid= ".$uid;
	mysqli_query($conn, $sql);
	
	$arr = array('sofar' => $newsofar, 'bal' => $newbal, 'status' => $status, 'rate' => $rate);
	echo json_encode($arr);
	
}

else if (strcasecmp($now, 's4_b') == 0) {

	//Update SOFAR
	$newsofar = $_GET ["s4_b_cost"]+$sofar;

	//Update BALANCE
	$newbal = $s_bal-$_GET ["s4_b_cost"];

	//////echo $s_bal.'      -          '.$_GET ["s4_b_cost"];

	//Update STATUS
	$status = 's4_c';

//get RATING
	$rt = $rate;
	$a = $_GET ["s4_a_rate"];

	
	if($rt>$a && $rt>$b)
	{
		$best=$rt;
	}else if($a>$b && $a>$rt)
	{
		$best = $a;
	}else{
		$best = $b;
		
	}

	$sql = "UPDATE tolly_user SET bal=".$newbal." WHERE  uid= ".$uid;
	mysqli_query($conn, $sql);

	$sql = "UPDATE tolly_ready_for_shoot SET progress=65, sofar=".$newsofar.", s='".$status."'  WHERE  rid=".$sid." and uid= ".$uid;
	mysqli_query($conn, $sql);


	$sql = "UPDATE tolly_s4 SET s4_b_rate=".$rate.", s4_status='".$status."', s4_best=".$best."   WHERE  sid=".$sid." and uid= ".$uid;
	mysqli_query($conn, $sql);

	$arr = array('sofar' => $newsofar, 'bal' => $newbal, 'status' => $status, 'rate' => $rate);
	echo json_encode($arr);
}

else if (strcasecmp($now, 's4_c') == 0) {
	
	//Update SOFAR
	$newsofar = $_GET ["s4_c_cost"]+$sofar;
	
	//Update BALANCE
	$newbal = $s_bal-$_GET ["s4_c_cost"];
	
	//////echo $s_bal.'      -          '.$_GET ["s4_c_cost"];
	
	//Update STATUS
	$status = 's5_a';
	
//get RATING
	$rt = $rate;
	$a = $_GET ["s4_a_rate"];
	$b = $_GET ["s4_b_rate"];
	
	if($rt>$a && $rt>$b)
	{
		$best=$rt;
	}else if($a>$b && $a>$rt)
	{
		$best = $a;
	}else{
		$best = $b;
		
	}	

	$sql = "UPDATE tolly_user SET bal=".$newbal." WHERE  uid= ".$uid;
	////echo '<h1>1 :   '.$sql.'</h1>';
	mysqli_query($conn, $sql);	
	
	$sql = "UPDATE tolly_ready_for_shoot SET progress=70, sofar=".$newsofar.", s='".$status."'  WHERE  rid=".$sid." and uid= ".$uid;
	////echo '<h1>2 :   '.$sql.'</h1>';
	mysqli_query($conn, $sql);
	
	
	$sql = "UPDATE tolly_s4 SET s4_c_rate=".$rate.", s4_status='".$status."', s4_best=".$best."  WHERE  sid=".$sid." and uid= ".$uid;
	////echo '<h1>3 :   '.$sql.'</h1>';
	mysqli_query($conn, $sql);
	
	$arr = array('sofar' => $newsofar, 'bal' => $newbal, 'status' => $status, 'rate' => $rate);
	echo json_encode($arr);
}

//----------------------------------------------------s4 end -----------------------------------------




//----------------------------------------------------------s5 logics---------------------------
else if (strcasecmp($now, 's5_a') == 0) {
	
	
	//Update SOFAR
	$newsofar = $_GET ["s5_a_cost"]+$sofar;
	
	//Update BALANCE
	$newbal = $s_bal-$_GET ["s5_a_cost"];
	
////echo $s_bal.'      -          '.$_GET ["s5_a_cost"];
	
	//Update STATUS
	$status = 's5_b';
	

	$sql = "UPDATE tolly_user SET bal=".$newbal." WHERE  uid= ".$uid;
	mysqli_query($conn, $sql);	
	
	$sql = "UPDATE tolly_ready_for_shoot SET progress=70, sofar=".$newsofar.", s='".$status."' WHERE  rid=".$sid." and uid= ".$uid;
	//echo  $sql;
	mysqli_query($conn, $sql);
	
	
	$sql = "UPDATE tolly_s5 SET s5_a_rate=".$rate.", s5_status='".$status."', s5_best=".$rate."   WHERE  sid=".$sid." and uid= ".$uid;
	mysqli_query($conn, $sql);
	
	$arr = array('sofar' => $newsofar, 'bal' => $newbal, 'status' => $status, 'rate' => $rate);
	echo json_encode($arr);
	
}

else if (strcasecmp($now, 's5_b') == 0) {

	//Update SOFAR
	$newsofar = $_GET ["s5_b_cost"]+$sofar;

	//Update BALANCE
	$newbal = $s_bal-$_GET ["s5_b_cost"];

	//////echo $s_bal.'      -          '.$_GET ["s5_b_cost"];

	//Update STATUS
	$status = 's5_c';

//get RATING
	$rt = $rate;
	$a = $_GET ["s5_a_rate"];
	
	
	if($rt>$a && $rt>$b)
	{
		$best=$rt;
	}else if($a>$b && $a>$rt)
	{
		$best = $a;
	}else{
		$best = $b;
		
	}

	$sql = "UPDATE tolly_user SET bal=".$newbal." WHERE  uid= ".$uid;
	mysqli_query($conn, $sql);

	$sql = "UPDATE tolly_ready_for_shoot SET progress=70, sofar=".$newsofar.", s='".$status."'  WHERE  rid=".$sid." and uid= ".$uid;
	mysqli_query($conn, $sql);


	$sql = "UPDATE tolly_s5 SET s5_b_rate=".$rate.", s5_status='".$status."', s5_best=".$best."    WHERE  sid=".$sid." and uid= ".$uid;
	mysqli_query($conn, $sql);

	$arr = array('sofar' => $newsofar, 'bal' => $newbal, 'status' => $status, 'rate' => $rate);
	echo json_encode($arr);
}

else if (strcasecmp($now, 's5_c') == 0) {
	
	//Update SOFAR
	$newsofar = $_GET ["s5_c_cost"]+$sofar;
	
	//Update BALANCE
	$newbal = $s_bal-$_GET ["s5_c_cost"];
	
	//////echo $s_bal.'      -          '.$_GET ["s5_c_cost"];
	
	//Update STATUS
	$status = 's6_a';
	
//get RATING
	$rt = $rate;
	$a = $_GET ["s5_a_rate"];
	$b = $_GET ["s5_b_rate"];
	
	if($rt>$a && $rt>$b)
	{
		$best=$rt;
	}else if($a>$b && $a>$rt)
	{
		$best = $a;
	}else{
		$best = $b;
		
	}	

	$sql = "UPDATE tolly_user SET bal=".$newbal." WHERE  uid= ".$uid;
	////echo '<h1>1 :   '.$sql.'</h1>';
	mysqli_query($conn, $sql);	
	
	$sql = "UPDATE tolly_ready_for_shoot SET progress=75, sofar=".$newsofar.", s='".$status."'  WHERE  rid=".$sid." and uid= ".$uid;
	////echo '<h1>2 :   '.$sql.'</h1>';
	mysqli_query($conn, $sql);
	
	
	$sql = "UPDATE tolly_s5 SET s5_c_rate=".$rate.", s5_status='".$status."', s5_best=".$best."  WHERE  sid=".$sid." and uid= ".$uid;
	////echo '<h1>3 :   '.$sql.'</h1>';
	mysqli_query($conn, $sql);
	
	$arr = array('sofar' => $newsofar, 'bal' => $newbal, 'status' => $status, 'rate' => $rate);
	echo json_encode($arr);
}

//----------------------------------------------------s5 end -----------------------------------------




//----------------------------------------------------------s6 logics---------------------------
else if (strcasecmp($now, 's6_a') == 0) {
	
	//Update SOFAR
	$newsofar = $_GET ["s6_a_cost"]+$sofar;
	
	//Update BALANCE
	$newbal = $s_bal-$_GET ["s6_a_cost"];
	
////echo $s_bal.'      -          '.$_GET ["s6_a_cost"];
	
	//Update STATUS
	$status = 's6_b';
	


	$sql = "UPDATE tolly_user SET bal=".$newbal." WHERE  uid= ".$uid;
	mysqli_query($conn, $sql);	
	
	$sql = "UPDATE tolly_ready_for_shoot SET progress=75, sofar=".$newsofar.", s='".$status."' WHERE  rid=".$sid." and uid= ".$uid;
	//echo  $sql;
	mysqli_query($conn, $sql);
	
	
	$sql = "UPDATE tolly_s6 SET s6_a_rate=".$rate.", s6_status='".$status."', s6_best=".$rate."   WHERE  sid=".$sid." and uid= ".$uid;
	mysqli_query($conn, $sql);
	
	$arr = array('sofar' => $newsofar, 'bal' => $newbal, 'status' => $status, 'rate' => $rate);
	echo json_encode($arr);
	
}

else if (strcasecmp($now, 's6_b') == 0) {

	//Update SOFAR
	$newsofar = $_GET ["s6_b_cost"]+$sofar;

	//Update BALANCE
	$newbal = $s_bal-$_GET ["s6_b_cost"];

	//////echo $s_bal.'      -          '.$_GET ["s6_b_cost"];

	//Update STATUS
	$status = 's6_c';

//get RATING
	$rt = $rate;
	$a = $_GET ["s6_a_rate"];

	
	if($rt>$a && $rt>$b)
	{
		$best=$rt;
	}else if($a>$b && $a>$rt)
	{
		$best = $a;
	}else{
		$best = $b;
		
	}

	$sql = "UPDATE tolly_user SET bal=".$newbal." WHERE  uid= ".$uid;
	mysqli_query($conn, $sql);

	$sql = "UPDATE tolly_ready_for_shoot SET progress=75, sofar=".$newsofar.", s='".$status."'  WHERE  rid=".$sid." and uid= ".$uid;
	mysqli_query($conn, $sql);


	$sql = "UPDATE tolly_s6 SET s6_b_rate=".$rate.", s6_status='".$status."', s6_best=".$best."    WHERE  sid=".$sid." and uid= ".$uid;
	mysqli_query($conn, $sql);

	$arr = array('sofar' => $newsofar, 'bal' => $newbal, 'status' => $status, 'rate' => $rate);
	echo json_encode($arr);
}

else if (strcasecmp($now, 's6_c') == 0) {
	
	//Update SOFAR
	$newsofar = $_GET ["s6_c_cost"]+$sofar;
	
	//Update BALANCE
	$newbal = $s_bal-$_GET ["s6_c_cost"];
	
	//////echo $s_bal.'      -          '.$_GET ["s6_c_cost"];
	
	//Update STATUS
	$status = 's7_a';
	
//get RATING
	$rt = $rate;
	$a = $_GET ["s6_a_rate"];
	$b = $_GET ["s6_b_rate"];
	
	if($rt>$a && $rt>$b)
	{
		$best=$rt;
	}else if($a>$b && $a>$rt)
	{
		$best = $a;
	}else{
		$best = $b;
		
	}

	$sql = "UPDATE tolly_user SET bal=".$newbal." WHERE  uid= ".$uid;
	////echo '<h1>1 :   '.$sql.'</h1>';
	mysqli_query($conn, $sql);	
	
	$sql = "UPDATE tolly_ready_for_shoot SET progress=80, sofar=".$newsofar.", s='".$status."'  WHERE  rid=".$sid." and uid= ".$uid;
	////echo '<h1>2 :   '.$sql.'</h1>';
	mysqli_query($conn, $sql);
	
	
	$sql = "UPDATE tolly_s6 SET s6_c_rate=".$rate.", s6_status='".$status."', s6_best=".$best."  WHERE  sid=".$sid." and uid= ".$uid;
	////echo '<h1>3 :   '.$sql.'</h1>';
	mysqli_query($conn, $sql);
	
	$arr = array('sofar' => $newsofar, 'bal' => $newbal, 'status' => $status, 'rate' => $rate);
	echo json_encode($arr);
}

//----------------------------------------------------s6 end -----------------------------------------

//----------------------------------------------------------s7 logics---------------------------
else if (strcasecmp($now, 's7_a') == 0) {
	
	//Update SOFAR
	$newsofar = $_GET ["s7_a_cost"]+$sofar;
	
	//Update BALANCE
	$newbal = $s_bal-$_GET ["s7_a_cost"];
	
////echo $s_bal.'      -          '.$_GET ["s7_a_cost"];
	
	//Update STATUS
	$status = 's7_b';
	
	//get RATING 
	$rt = $rate;	

	$sql = "UPDATE tolly_user SET bal=".$newbal." WHERE  uid= ".$uid;
	mysqli_query($conn, $sql);	
	
	$sql = "UPDATE tolly_ready_for_shoot SET progress=80, sofar=".$newsofar.", s='".$status."' WHERE  rid=".$sid." and uid= ".$uid;
	//echo  $sql;
	mysqli_query($conn, $sql);
	
	
	$sql = "UPDATE tolly_s7 SET s7_a_rate=".$rate.", s7_status='".$status."', s7_best=".$rate."   WHERE  sid=".$sid." and uid= ".$uid;
	mysqli_query($conn, $sql);
	
	$arr = array('sofar' => $newsofar, 'bal' => $newbal, 'status' => $status, 'rate' => $rate);
	echo json_encode($arr);
	
}

else if (strcasecmp($now, 's7_b') == 0) {

	//Update SOFAR
	$newsofar = $_GET ["s7_b_cost"]+$sofar;

	//Update BALANCE
	$newbal = $s_bal-$_GET ["s7_b_cost"];

	//////echo $s_bal.'      -          '.$_GET ["s7_b_cost"];

	//Update STATUS
	$status = 's7_c';

//get RATING
	$rt = $rate;
	$a = $_GET ["s7_a_rate"];

	
	if($rt>$a && $rt>$b)
	{
		$best=$rt;
	}else if($a>$b && $a>$rt)
	{
		$best = $a;
	}else{
		$best = $b;
		
	}

	$sql = "UPDATE tolly_user SET bal=".$newbal." WHERE  uid= ".$uid;
	mysqli_query($conn, $sql);

	$sql = "UPDATE tolly_ready_for_shoot SET progress=80, sofar=".$newsofar.", s='".$status."'  WHERE  rid=".$sid." and uid= ".$uid;
	mysqli_query($conn, $sql);


	$sql = "UPDATE tolly_s7 SET s7_b_rate=".$rate.", s7_status='".$status."', s7_best=".$best."    WHERE  sid=".$sid." and uid= ".$uid;
	mysqli_query($conn, $sql);

	$arr = array('sofar' => $newsofar, 'bal' => $newbal, 'status' => $status, 'rate' => $rate);
	echo json_encode($arr);
}

else if (strcasecmp($now, 's7_c') == 0) {
	
	//Update SOFAR
	$newsofar = $_GET ["s7_c_cost"]+$sofar;
	
	//Update BALANCE
	$newbal = $s_bal-$_GET ["s7_c_cost"];
	
	//////echo $s_bal.'      -          '.$_GET ["s7_c_cost"];
	
	//Update STATUS
	$status = 's8_a';
	
//get RATING
	$rt = $rate;
	$a = $_GET ["s7_a_rate"];
	$b = $_GET ["s7_b_rate"];
	
	if($rt>$a && $rt>$b)
	{
		$best=$rt;
	}else if($a>$b && $a>$rt)
	{
		$best = $a;
	}else{
		$best = $b;
		
	}
	

	$sql = "UPDATE tolly_user SET bal=".$newbal." WHERE  uid= ".$uid;
	////echo '<h1>1 :   '.$sql.'</h1>';
	mysqli_query($conn, $sql);	
	
	$sql = "UPDATE tolly_ready_for_shoot SET progress=80, sofar=".$newsofar.", s='".$status."'  WHERE  rid=".$sid." and uid= ".$uid;
	////echo '<h1>2 :   '.$sql.'</h1>';
	mysqli_query($conn, $sql);
	
	
	$sql = "UPDATE tolly_s7 SET s7_c_rate=".$rate.", s7_status='".$status."', s7_best=".$best."  WHERE  sid=".$sid." and uid= ".$uid;
	////echo '<h1>3 :   '.$sql.'</h1>';
	mysqli_query($conn, $sql);
	
	$arr = array('sofar' => $newsofar, 'bal' => $newbal, 'status' => $status, 'rate' => $rate);
	echo json_encode($arr);
}

//----------------------------------------------------s7 end -----------------------------------------
//----------------------------------------------------------s8 logics---------------------------
else if (strcasecmp($now, 's8_a') == 0) {
	
	//Update SOFAR
	$newsofar = $_GET ["s8_a_cost"]+$sofar;
	
	//Update BALANCE
	$newbal = $s_bal-$_GET ["s8_a_cost"];
	
////echo $s_bal.'      -          '.$_GET ["s8_a_cost"];
	
	//Update STATUS
	$status = 's8_b';
	
	//get RATING 
	$rt = $rate;	

	$sql = "UPDATE tolly_user SET bal=".$newbal." WHERE  uid= ".$uid;
	mysqli_query($conn, $sql);	
	
	$sql = "UPDATE tolly_ready_for_shoot SET progress=85, sofar=".$newsofar.", s='".$status."' WHERE  rid=".$sid." and uid= ".$uid;
	//echo  $sql;
	mysqli_query($conn, $sql);
	
	
	$sql = "UPDATE tolly_s8 SET s8_a_rate=".$rate.", s8_status='".$status."', s8_best=".$rate."   WHERE  sid=".$sid." and uid= ".$uid;
	mysqli_query($conn, $sql);
	
	$arr = array('sofar' => $newsofar, 'bal' => $newbal, 'status' => $status, 'rate' => $rate);
	echo json_encode($arr);
	
}

else if (strcasecmp($now, 's8_b') == 0) {

	//Update SOFAR
	$newsofar = $_GET ["s8_b_cost"]+$sofar;

	//Update BALANCE
	$newbal = $s_bal-$_GET ["s8_b_cost"];

	//////echo $s_bal.'      -          '.$_GET ["s8_b_cost"];

	//Update STATUS
	$status = 's8_c';

//get RATING
	$rt = $rate;
	$a = $_GET ["s8_a_rate"];

	
	if($rt>$a && $rt>$b)
	{
		$best=$rt;
	}else if($a>$b && $a>$rt)
	{
		$best = $a;
	}else{
		$best = $b;
		
	}
	

	$sql = "UPDATE tolly_user SET bal=".$newbal." WHERE  uid= ".$uid;
	mysqli_query($conn, $sql);

	$sql = "UPDATE tolly_ready_for_shoot SET progress=85, sofar=".$newsofar.", s='".$status."'  WHERE  rid=".$sid." and uid= ".$uid;
	mysqli_query($conn, $sql);


	$sql = "UPDATE tolly_s8 SET s8_b_rate=".$rate.", s8_status='".$status."', s8_best=".$best."    WHERE  sid=".$sid." and uid= ".$uid;
	mysqli_query($conn, $sql);

	$arr = array('sofar' => $newsofar, 'bal' => $newbal, 'status' => $status, 'rate' => $rate);
	echo json_encode($arr);
}

else if (strcasecmp($now, 's8_c') == 0) {
	
	//Update SOFAR
	$newsofar = $_GET ["s8_c_cost"]+$sofar;
	
	//Update BALANCE
	$newbal = $s_bal-$_GET ["s8_c_cost"];
	
	//////echo $s_bal.'      -          '.$_GET ["s8_c_cost"];
	
	//Update STATUS
	$status = 's9_a';
	
//get RATING
	$rt = $rate;
	$a = $_GET ["s8_a_rate"];
	$b = $_GET ["s8_b_rate"];
	
	if($rt>$a && $rt>$b)
	{
		$best=$rt;
	}else if($a>$b && $a>$rt)
	{
		$best = $a;
	}else{
		$best = $b;
		
	}	

	$sql = "UPDATE tolly_user SET bal=".$newbal." WHERE  uid= ".$uid;
	////echo '<h1>1 :   '.$sql.'</h1>';
	mysqli_query($conn, $sql);	
	
	$sql = "UPDATE tolly_ready_for_shoot SET progress=85, sofar=".$newsofar.", s='".$status."'  WHERE  rid=".$sid." and uid= ".$uid;
	////echo '<h1>2 :   '.$sql.'</h1>';
	mysqli_query($conn, $sql);
	
	
	$sql = "UPDATE tolly_s8 SET s8_c_rate=".$rate.", s8_status='".$status."', s8_best=".$best."  WHERE  sid=".$sid." and uid= ".$uid;
	////echo '<h1>3 :   '.$sql.'</h1>';
	mysqli_query($conn, $sql);
	
	$arr = array('sofar' => $newsofar, 'bal' => $newbal, 'status' => $status, 'rate' => $rate);
	echo json_encode($arr);
}

//----------------------------------------------------s8 end -----------------------------------------




//----------------------------------------------------------s9 logics---------------------------
else if (strcasecmp($now, 's9_a') == 0) {
	
	//Update SOFAR
	$newsofar = $_GET ["s9_a_cost"]+$sofar;
	
	//Update BALANCE
	$newbal = $s_bal-$_GET ["s9_a_cost"];
	
////echo $s_bal.'      -          '.$_GET ["s9_a_cost"];
	
	//Update STATUS
	$status = 's9_b';
	
	//get RATING 
	$rt = $rate;	

	$sql = "UPDATE tolly_user SET bal=".$newbal." WHERE  uid= ".$uid;
	mysqli_query($conn, $sql);	
	
	$sql = "UPDATE tolly_ready_for_shoot SET progress=90, sofar=".$newsofar.", s='".$status."' WHERE  rid=".$sid." and uid= ".$uid;
	//echo  $sql;
	mysqli_query($conn, $sql);
	
	
	$sql = "UPDATE tolly_s9 SET s9_a_rate=".$rate.", s9_status='".$status."', s9_best=".$rate."   WHERE  sid=".$sid." and uid= ".$uid;
	mysqli_query($conn, $sql);
	
	$arr = array('sofar' => $newsofar, 'bal' => $newbal, 'status' => $status, 'rate' => $rate);
	echo json_encode($arr);
	
}

else if (strcasecmp($now, 's9_b') == 0) {

	//Update SOFAR
	$newsofar = $_GET ["s9_b_cost"]+$sofar;

	//Update BALANCE
	$newbal = $s_bal-$_GET ["s9_b_cost"];

	//////echo $s_bal.'      -          '.$_GET ["s9_b_cost"];

	//Update STATUS
	$status = 's9_c';

//get RATING
	$rt = $rate;
	$a = $_GET ["s9_a_rate"];
	
	
	if($rt>$a && $rt>$b)
	{
		$best=$rt;
	}else if($a>$b && $a>$rt)
	{
		$best = $a;
	}else{
		$best = $b;
		
	}

	$sql = "UPDATE tolly_user SET bal=".$newbal." WHERE  uid= ".$uid;
	mysqli_query($conn, $sql);

	$sql = "UPDATE tolly_ready_for_shoot SET progress=95, sofar=".$newsofar.", s='".$status."'  WHERE  rid=".$sid." and uid= ".$uid;
	mysqli_query($conn, $sql);


	$sql = "UPDATE tolly_s9 SET s9_b_rate=".$rate.", s9_status='".$status."', s9_best=".$best."    WHERE  sid=".$sid." and uid= ".$uid;
	mysqli_query($conn, $sql);

	$arr = array('sofar' => $newsofar, 'bal' => $newbal, 'status' => $status, 'rate' => $rate);
	echo json_encode($arr);
}

else if (strcasecmp($now, 's9_c') == 0) {
	
	//Update SOFAR
	$newsofar = $_GET ["s9_c_cost"]+$sofar;
	
	//Update BALANCE
	$newbal = $s_bal-$_GET ["s9_c_cost"];
	
	//////echo $s_bal.'      -          '.$_GET ["s9_c_cost"];
	
	//Update STATUS
	$status = 's10_a';
	

//get RATING
	$rt = $rate;
	$a = $_GET ["s9_a_rate"];
	$b = $_GET ["s9_b_rate"];
	
	if($rt>$a && $rt>$b)
	{
		$best=$rt;
	}else if($a>$b && $a>$rt)
	{
		$best = $a;
	}else{
		$best = $b;		
	}	

	$sql = "UPDATE tolly_user SET bal=".$newbal." WHERE  uid= ".$uid;
	////echo '<h1>1 :   '.$sql.'</h1>';
	mysqli_query($conn, $sql);	
	
	$sql = "UPDATE tolly_ready_for_shoot SET progress=95, sofar=".$newsofar.", s='".$status."'  WHERE  rid=".$sid." and uid= ".$uid;
	////echo '<h1>2 :   '.$sql.'</h1>';
	mysqli_query($conn, $sql);
	
	
	$sql = "UPDATE tolly_s9 SET s9_c_rate=".$rate.", s9_status='".$status."', s9_best=".$best."  WHERE  sid=".$sid." and uid= ".$uid;
	////echo '<h1>3 :   '.$sql.'</h1>';
	mysqli_query($conn, $sql);
	
	$arr = array('sofar' => $newsofar, 'bal' => $newbal, 'status' => $status, 'rate' => $rate, 'progress' => $progress);
	echo json_encode($arr);
}

//----------------------------------------------------s9 end -----------------------------------------


else {
	
	
}

?>

