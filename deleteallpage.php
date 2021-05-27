<?php
/**
* Multi file upload example
* @author Resalat Haque
* @link http://www.w3bees.com/2013/02/multiple-file-upload-with-php.html
**/

include 'db.php';

$aid = $_POST["aid"];
$table = $_POST["table"];



function clean($string) {
   $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}





if($table=='actor')
{

		$sql1 = "DELETE FROM `tolly_actor` WHERE  `actor_id`=".$aid	;
		
		 
		
		echo $sql1;
		
		
		
		$t = mysqli_query ( $conn, $sql1 );
		//echo $t;
		if ($t) {
			echo '<h1>'.$table.'    DATA RECORD DELETED  <h1>';
			
		} else {
			echo 'ERROR';
		}
}



if($table=='actress')
{
		$sql1 = "DELETE FROM `tolly_actress` WHERE  `actress_id`=".$aid	;
		 
	echo $sql1;



	$t = mysqli_query ( $conn, $sql1 );
	//echo $t;
	if ($t) {
		echo '<h1>'.$table.'    DATA RECORD DELETED  <h1>';
			
	} else {
		echo 'ERROR';
	}
}


if($table=='director')
{
	
	$sql1 = "DELETE FROM `tolly_director` WHERE  `director_id`=".$aid	;

		 

	echo $sql1;



	$t = mysqli_query ( $conn, $sql1 );
	//echo $t;
	if ($t) {
		echo '<h1>'.$table.'    DATA RECORD DELETED  <h1>';
			
	} else {
		echo 'ERROR';
	}
}




if($table=='music')
{
	
	$sql1 = "DELETE FROM `tolly_music` WHERE  `music_id`=".$aid	;

	 

	echo $sql1;



	$t = mysqli_query ( $conn, $sql1 );
	//echo $t;
	if ($t) {
		echo '<h1>'.$table.'    DATA RECORD DELETED  <h1>';
			
	} else {
		echo 'ERROR';
	}
}



if($table=='cine')
{
	
	$sql1 = "DELETE FROM `tolly_cine` WHERE  `cine_id`=".$aid	;

	echo $sql1;



	$t = mysqli_query ( $conn, $sql1 );
	//echo $t;
	if ($t) {
		echo '<h1>'.$table.'    DATA RECORD DELETED  <h1>';
			
	} else {
		echo 'ERROR';
	}
}




if($table=='editor')
{


$sql1 = "DELETE FROM `tolly_editor` WHERE  `editor_id`=".$aid	;

		 
	echo $sql1;



	$t = mysqli_query ( $conn, $sql1 );
	//echo $t;
	if ($t) {
		echo '<h1>'.$table.'    DATA RECORD DELETED  <h1>';
			
	} else {
		echo 'ERROR';
	}
}



if($table=='writer')
{


$sql1 = "DELETE FROM `tolly_writer` WHERE  `writer_id`=".$aid	;

	 

	echo $sql1;



	$t = mysqli_query ( $conn, $sql1 );
	//echo $t;
	if ($t) {
		echo '<h1>'.$table.'    RECORD DELETED <h1>';
			
	} else {
		echo '<h1>ERROR';
	}
}



echo "<h2> <a href=\"javascript:history.back()\">Go Back</a> </h2>"




?>
