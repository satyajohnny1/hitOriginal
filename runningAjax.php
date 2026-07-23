<?php
include 'db.php';
include 'balance.php';
session_start();

$uid =  $_SESSION['s_uid'];
$bal = $_SESSION['s_bal']; 
$rid = $_GET ["rid"];
$day = $_GET ["day"];
$cday = $_GET ["day"];

$wk1_cen=0;
$wk2_cen=0;
$d25_cen=0;
$d50_cen=0;
$d75_cen=0;
$d100_cen=0;
$d125_cen=0;
$d150_cen=0;
$d175_cen=0; 
$wk1_coll=0;
$wk2_coll=0;
$d25_coll=0;
$d50_coll=0;
$d75_coll=0;
$d100_coll=0;
$d125_coll=0;
$d150_coll=0;
$d175_coll=0; 
$max_days = 0;
$max_coll = 0;


$wk1_unit = 0;
$wk2_unit = 0;
$d25_unit = 0;
$d50_unit = 0;
$d75_unit = 0;
$d100_unit = 0;
$d125_unit = 0;
$d150_unit = 0;
$d175_unit = 0;

$status = 1;
 
 
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


$wk1_unit	=	$wk1_coll/7;
$wk2_unit	=	$wk2_coll/7;
$d25_unit	=	$d25_coll/11;
$d50_unit	=	$d50_coll/25;
$d75_unit	=	$d75_coll/25;
$d100_unit	=	$d100_coll/25;
$d125_unit	=	$d125_coll/25;
$d150_unit	=	$d150_coll/25;
$d175_unit	=	$d175_coll/25;

$coll = 0;
$cent = 0;

if($day>=$max_days)
{
	$q1 = "UPDATE tolly_ready_for_shoot SET status='out' WHERE  rid=".$rid." and uid=".$uid;
	mysqli_query($conn, $q1);
	
	$q2 = "UPDATE tolly_release SET status='out' WHERE  rid=".$rid." and uid=".$uid;
	mysqli_query($conn, $q2);
	
	
	$newbal = round(floatval($bal)+floatval($max_coll));
	$sql = "UPDATE tolly_user SET bal=".$newbal." WHERE  uid= ".$uid;
	if($stat=='running')
	{
	mysqli_query($conn, $sql);
	}
	
	$cent = 0;
	$coll = $max_coll;
	$status = -1;
	
}

else if($day<7)
{	
	
	
		$cent = $rel_cen;
	
	
	
	$coll = round($wk1_unit*$day);
}
else if($day<14)
{	
	
	$day = $day-7;
	$cent = $wk1_cen;
	$coll = round($wk1_coll+($wk2_unit*$day));
	
}
 
else if($day<21)
{
	$day = $day-14;
	$cent = $wk2_cen;
	$coll = round($wk1_coll+$wk2_coll+($d25_unit*$day));
	
	
}
else if($day<28)

{

	$day = $day-14;	$cent = $wk2_cen;

	$coll = round($wk1_coll+$wk2_coll+($d25_unit*$day));

	

		$cent = $d25_cen;

	

	if($d25_cen<1)

	{

		$cent = 1;

	}

	

}
else if($day<=50)
{	$day = $day-25;
	$cent = $d25_cen;
	$coll = round($wk1_coll+$wk2_coll+$d25_coll+($d50_unit*$day));
	if($cday>35)
	{
		$cent = $d50_cen;
	}
	if($d50_cen<1)
	{
		$cent = 1;
	}
}
else if($day<75)
{
	$day = $day-50;
	$cent = $d50_cen;
	if($cday>53)
	{
		$cent = $d75_cen;
	}
	if($d75_cen<1)
	{
		$cent = 1;
	}
	
	$coll = round($wk1_coll+$wk2_coll+$d25_coll+$d50_coll+($d75_unit*$day));
}
else if($day<100)
{
		$day = $day-75;
		$cent = $d75_cen;
		$coll = round($wk1_coll+$wk2_coll+$d25_coll+$d50_coll+$d75_coll+($d100_unit*$day));
		if($cday>78)
		{
			$cent = $d100_cen;
		}
		
		if($d100_cen<1)
		{
			$cent = 1;
		}
		
}
else if($day<125)
{
	$day = $day-100;
	$cent = $d100_cen;
	$coll = round($wk1_coll+$wk2_coll+$d25_coll+$d50_coll+$d75_coll+$d100_coll+($d125_unit*$day));
	if($cday>104)
	{
		$cent = $d125_cen;
	}
	if($d125_cen<1)
	{
		$cent = 1;
	}
}
else if($day<150)
{
	$day = $day-125;
	$cent = $d125_cen;
	$coll = round($wk1_coll+$wk2_coll+$d25_coll+$d50_coll+$d75_coll+$d100_coll+$d125_coll+($d150_unit*$day));
	if($cday>128)
	{
		$cent = $d150_cen;
	}
	if($d150_cen<1)
	{
		$cent = 1;
	}
}
else if($day<175)
{
	$day = $day-150;
	$cent = $d150_cen;
	$coll = round($wk1_coll+$wk2_coll+$d25_coll+$d50_coll+$d75_coll+$d100_coll+$d125_coll+$d150_coll+($d175_unit*$day));
	if($cday>154)
	{
		$cent = $d175_cen;
	}
	if($d175_cen<1)
	{
		$cent = 1;
	}
	
}else{
	
	$coll = $max_coll;
}

 
$arr = array('coll' => $coll, 'cent' => $cent, 'status' => $status);
echo json_encode($arr);
 
  
?>
 
