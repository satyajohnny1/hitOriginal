<?php

include 'db.php';
session_start(); // Starting Session




$s_uid = $_SESSION["s_uid"];
$itype = $_POST["itype"];
$msg='';
$status=0;
$link = "";
 
 //echo 'Type ---> '.$itype;

if($itype=='pro')
{
	$uname = $_POST["uname"];
	$email = $_POST["email"];
	$banner = $_POST["banner"];
    $bal = $_POST["bal"];
	if($uname!=null && $banner!=null)
	{
	
	
	//echo 'IN PROoooooooooooooooo---> ';
 	// Regisred Checking
	$sql = "UPDATE `tolly_user` SET `username`='".$uname."',   `email`='".$email."',  `banner`='".$banner."',  `bal`=".$bal." WHERE  `uid`=".$s_uid;
	$status = $sql;
	$result = mysqli_query ( $conn, $sql );
	//echo '----> '.$sql;
	
	if ($result  > 0) {
		$msg= "Data Update Successfully ";
		////echo 'Im in AALreday Exixt';
		
	}
	}else{
		$msg= "Please Insert Valid Details ";
		
	}
 

}



if($itype=='pwd')
{

	$password = $_POST["password"];
	if ($password!=null) {

		// Regisred Checking

		$sql = "UPDATE `tolly_user` SET `password`='".$password."' WHERE  `uid`=".$s_uid;
		$status = $sql;
		$result = mysqli_query ( $conn, $sql );

		if ( $result > 0) {
			$msg= "Password Update Successfully ";
			////echo 'Im in AALreday Exixt';
		
		}



	} else {

		$msg=  "<h1>Please Enter all the Deatails</h1>";


	}

}

 
 

$arr = array('msg' => $msg, 'status' => $status);
echo json_encode($arr);



?>
