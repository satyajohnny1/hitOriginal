<?php
/**
* Multi file upload example
* @author Resalat Haque
* @link http://www.w3bees.com/2013/02/multiple-file-upload-with-php.html
**/

include 'db.php';


$hostpath = $_POST["hostpath"];
 

 
		$sql1 = "INSERT INTO `tolly_actor` (`actor_name`, `actor_rate`, `actor_grade`, `actor_pic`, `actor_status`, `actor_rating`) VALUES 		
		('$xname', $rate, '$grade', '$pic','$status','$rating')";
		
		echo $sql1;
		
		
		
		$t = mysqli_query ( $conn, $sql1 );
		//echo $t;
		if ($t) {
			echo '<h1> DATA INSTRED<h1>';
			
		} else {
			echo 'ERROR';
		} 






?>
 
 