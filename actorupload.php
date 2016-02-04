<?php
/**
* Multi file upload example
* @author Resalat Haque
* @link http://www.w3bees.com/2013/02/multiple-file-upload-with-php.html
**/

include 'db.php';


$xname = $_POST["aname"];
$name = $_POST["aname"];
$rate = $_POST["arate"];
$grade = $_POST["agrade"];
$pic = '';
$status = $_POST["astatus"];
$rating = $_POST["arating"];
$upname = clean($name);
$table = $_POST["table"];


echo $upname;

$valid_formats = array("jpg", "png", "jpeg", "gif", "zip", "bmp");
$max_file_size = 3024*2000; //100 kb
$path = "poster/"; // Upload directory
$count = 0;

function clean($string) {
   $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}


if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
	// Loop $_FILES to execute all files
	foreach ($_FILES['files']['name'] as $f => $name) {

	
$newname = $upname.'.png';			
	    if ($_FILES['files']['error'][$f] == 4) {
	        continue; // Skip file if any error found
	    }	       
	    if ($_FILES['files']['error'][$f] == 0) {	           
	        if ($_FILES['files']['size'][$f] > $max_file_size) {
	            $message[] = "$name is too large!.";
	            continue; // Skip large files
	        }
			elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
				$message[] = "$name is not a valid format";
				continue; // Skip invalid file formats
			}
	        else{ // No error found! Move uploaded files 
	            if(move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path.$newname)) {
	            	$count++; // Number of successfully uploaded files
	            }
	        }
	    }
	}
}
$pic = $path.$newname;


if($table=='actor')
{

		$sql1 = "INSERT INTO `tolly_actor` (`actor_name`, `actor_rate`, `actor_grade`, `actor_pic`, `actor_status`, `actor_rating`) VALUES 		
		('$xname', $rate, '$grade', '$pic','$status','$rating')";
		
		echo $sql1;
		
		
		
		$t = mysqli_query ( $conn, $sql1 );
		//echo $t;
		if ($t) {
			echo '<h1>'.$table.'    DATA INSTRED<h1>';
			
		} else {
			echo 'ERROR';
		}
}



if($table=='actress')
{

	$sql1 = "INSERT INTO `tolly_actress` (`actress_name`, `actress_rate`, `actress_grade`, `actress_pic`, `actress_status`, `actress_rating`) VALUES
	('$xname', $rate, '$grade', '$pic','$status','$rating')";

	echo $sql1;



	$t = mysqli_query ( $conn, $sql1 );
	//echo $t;
	if ($t) {
		echo '<h1>'.$table.'    DATA INSTRED<h1>';
			
	} else {
		echo 'ERROR';
	}
}


if($table=='director')
{

	$sql1 = "INSERT INTO `tolly_director` (`director_name`, `director_rate`, `director_grade`, `director_pic`, `director_status`, `director_rating`) VALUES
	('$xname', $rate, '$grade', '$pic','$status','$rating')";

	echo $sql1;



	$t = mysqli_query ( $conn, $sql1 );
	//echo $t;
	if ($t) {
		echo '<h1>'.$table.'    DATA INSTRED<h1>';
			
	} else {
		echo 'ERROR';
	}
}




if($table=='music')
{

	$sql1 = "INSERT INTO `tolly_music` (`music_name`, `music_rate`, `music_grade`, `music_pic`, `music_status`, `music_rating`) VALUES
	('$xname', $rate, '$grade', '$pic','$status','$rating')";

	echo $sql1;



	$t = mysqli_query ( $conn, $sql1 );
	//echo $t;
	if ($t) {
		echo '<h1>'.$table.'    DATA INSTRED<h1>';
			
	} else {
		echo 'ERROR';
	}
}



if($table=='cine')
{

	$sql1 = "INSERT INTO `tolly_cine` (`cine_name`, `cine_rate`, `cine_grade`, `cine_pic`, `cine_status`, `cine_rating`) VALUES
	('$xname', $rate, '$grade', '$pic','$status','$rating')";

	echo $sql1;



	$t = mysqli_query ( $conn, $sql1 );
	//echo $t;
	if ($t) {
		echo '<h1>'.$table.'    DATA INSTRED<h1>';
			
	} else {
		echo 'ERROR';
	}
}




if($table=='editor')
{

	$sql1 = "INSERT INTO `tolly_editor` (`editor_name`, `editor_rate`, `editor_grade`, `editor_pic`, `editor_status`, `editor_rating`) VALUES
	('$xname', $rate, '$grade', '$pic','$status','$rating')";

	echo $sql1;



	$t = mysqli_query ( $conn, $sql1 );
	//echo $t;
	if ($t) {
		echo '<h1>'.$table.'    DATA INSTRED<h1>';
			
	} else {
		echo 'ERROR';
	}
}



if($table=='writer')
{

	$sql1 = "INSERT INTO `tolly_writer` (`writer_name`, `writer_rate`, `writer_grade`, `writer_pic`, `writer_status`, `writer_rating`) VALUES
	('$xname', $rate, '$grade', '$pic','$status','$rating')";

	echo $sql1;



	$t = mysqli_query ( $conn, $sql1 );
	//echo $t;
	if ($t) {
		echo '<h1>'.$table.'    DATA INSTRED<h1>';
			
	} else {
		echo 'ERROR';
	}
}








?>
<head>
	<meta charset="UTF-8" />
	<title>Multiple File Upload with PHP - Demo</title>
<style type="text/css">
a{ text-decoration: none; color: #333}
h1{ font-size: 1.9em; margin: 10px 0}
p{ margin: 8px 0}
*{
	margin: 0;
	padding: 0;
	box-sizing: border-box;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	-webkit-font-smoothing: antialiased;
	-moz-font-smoothing: antialiased;
	-o-font-smoothing: antialiased;
	font-smoothing: antialiased;
	text-rendering: optimizeLegibility;
}
body{
	font: 12px Arial,Tahoma,Helvetica,FreeSans,sans-serif;
	text-transform: inherit;
	color: #333;
	background: #e7edee;
	width: 100%;
	line-height: 18px;
}
.wrap{
	width: 500px;
	margin: 15px auto;
	padding: 20px 25px;
	background: white;
	border: 2px solid #DBDBDB;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	overflow: hidden;
	text-align: center;
}
.status{
	/*display: none;*/
	padding: 8px 35px 8px 14px;
	margin: 20px 0;
	text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
	color: #468847;
	background-color: #dff0d8;
	border-color: #d6e9c6;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
}
input[type="submit"] {
	cursor:pointer;
	width:100%;
	border:none;
	background:#991D57;
	background-image:linear-gradient(bottom, #8C1C50 0%, #991D57 52%);
	background-image:-moz-linear-gradient(bottom, #8C1C50 0%, #991D57 52%);
	background-image:-webkit-linear-gradient(bottom, #8C1C50 0%, #991D57 52%);
	color:#FFF;
	font-weight: bold;
	margin: 20px 0;
	padding: 10px;
	border-radius:5px;
}
input[type="submit"]:hover {
	background-image:linear-gradient(bottom, #9C215A 0%, #A82767 52%);
	background-image:-moz-linear-gradient(bottom, #9C215A 0%, #A82767 52%);
	background-image:-webkit-linear-gradient(bottom, #9C215A 0%, #A82767 52%);
	-webkit-transition:background 0.3s ease-in-out;
	-moz-transition:background 0.3s ease-in-out;
	transition:background-color 0.3s ease-in-out;
}
input[type="submit"]:active {
	box-shadow:inset 0 1px 3px rgba(0,0,0,0.5);
}
</style>

</head>
<div class="wrap">
		<h1><a href="http://www.w3bees.com/2013/02/multiple-file-upload-with-php.html">Multiple File Upload with PHP</a></h1>
		<?php
		# error messages
		if (isset($message)) {
			foreach ($message as $msg) {
				printf("<p class='status'>%s</p></ br>\n", $msg);
			}
		}
		# success message
		if($count !=0){
			printf("<p class='status'>%d files added successfully!</p>\n", $count);
		}
		?>
		<p>Max file size 100kb, Valid formats jpg, png, gif</p>
		<br />
		<br />
		<H1><a href="actordata.php">BACK</a></H1>
		
</div>