<?php
/**
* Multi file upload example
* @author Resalat Haque
* @link http://www.w3bees.com/2013/02/multiple-file-upload-with-php.html
**/

include 'db.php';

$aid = $_POST["aid"];
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



function clean($string) {
   $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

$picPath = null;
$deletePic = isset($_POST['delete_pic']) && $_POST['delete_pic'] === '1';

if ($table === 'actor' || $table === 'actress') {
    if (isset($_FILES['actor_pic']) && $_FILES['actor_pic']['error'] === UPLOAD_ERR_OK) {
        $validFormats = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $tmpName = $_FILES['actor_pic']['tmp_name'];
        $origName = $_FILES['actor_pic']['name'];
        $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
        if (!in_array($ext, $validFormats)) {
            echo '<h1>Invalid image format. Allowed: jpg, jpeg, png, gif, webp</h1>';
            exit;
        }
        $picPath = 'poster/' . clean($name) . '.png';
        $picPathDb = $picPath;
        move_uploaded_file($tmpName, $picPath);
    } elseif ($deletePic) {
        $picPathDb = '';
    }
}

if ($table === 'actor') {
    if ($picPath !== null) {
        $oldSql = "SELECT actor_pic FROM tolly_actor WHERE actor_id=" . $aid;
        $oldRes = mysqli_query($conn, $oldSql);
        $oldRow = mysqli_fetch_assoc($oldRes);
        if ($oldRow && !empty($oldRow['actor_pic']) && $oldRow['actor_pic'] !== $picPath) {
            $oldFile = $oldRow['actor_pic'];
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }
    } elseif ($deletePic) {
        $oldSql = "SELECT actor_pic FROM tolly_actor WHERE actor_id=" . $aid;
        $oldRes = mysqli_query($conn, $oldSql);
        $oldRow = mysqli_fetch_assoc($oldRes);
        if ($oldRow && !empty($oldRow['actor_pic'])) {
            $oldFile = $oldRow['actor_pic'];
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }
    }

    $picSet = '';
    if ($picPath !== null) {
        $picSet = "`actor_pic`='" . mysqli_real_escape_string($conn, $picPath) . "', ";
    } elseif ($deletePic) {
        $picSet = "`actor_pic`='', ";
    }

    $sql1 = "UPDATE `tolly_actor` SET " . $picSet . "`actor_name`='".$xname."', `actor_rate`='".$rate."', `actor_grade`='".$grade."', `actor_status`='".$status."', `actor_rating`='".$rating."' WHERE  `actor_id`=".$aid	;
		 
		
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
    if ($picPath !== null) {
        $oldSql = "SELECT actress_pic FROM tolly_actress WHERE actress_id=" . $aid;
        $oldRes = mysqli_query($conn, $oldSql);
        $oldRow = mysqli_fetch_assoc($oldRes);
        if ($oldRow && !empty($oldRow['actress_pic']) && $oldRow['actress_pic'] !== $picPath) {
            $oldFile = $oldRow['actress_pic'];
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }
    } elseif ($deletePic) {
        $oldSql = "SELECT actress_pic FROM tolly_actress WHERE actress_id=" . $aid;
        $oldRes = mysqli_query($conn, $oldSql);
        $oldRow = mysqli_fetch_assoc($oldRes);
        if ($oldRow && !empty($oldRow['actress_pic'])) {
            $oldFile = $oldRow['actress_pic'];
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }
    }

    $picSet = '';
    if ($picPath !== null) {
        $picSet = "`actress_pic`='" . mysqli_real_escape_string($conn, $picPath) . "', ";
    } elseif ($deletePic) {
        $picSet = "`actress_pic`='', ";
    }

    $sql1 = "UPDATE `tolly_actress` SET " . $picSet . "`actress_name`='".$xname."', `actress_rate`='".$rate."', `actress_grade`='".$grade."', `actress_status`='".$status."', `actress_rating`='".$rating."' WHERE  `actress_id`=".$aid	;

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

		$sql1 = "UPDATE `tolly_director` SET `director_name`='".$xname."', `director_rate`='".$rate."', `director_grade`='".$grade."', `director_status`='".$status."', `director_rating`='".$rating."' WHERE  `director_id`=".$aid	;

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

		$sql1 = "UPDATE `tolly_music` SET `music_name`='".$xname."', `music_rate`='".$rate."', `music_grade`='".$grade."', `music_status`='".$status."', `music_rating`='".$rating."' WHERE  `music_id`=".$aid	;

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

		$sql1 = "UPDATE `tolly_cine` SET `cine_name`='".$xname."', `cine_rate`='".$rate."', `cine_grade`='".$grade."', `cine_status`='".$status."', `cine_rating`='".$rating."' WHERE  `cine_id`=".$aid	;

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

		$sql1 = "UPDATE `tolly_editor` SET `editor_name`='".$xname."', `editor_rate`='".$rate."', `editor_grade`='".$grade."', `editor_status`='".$status."', `editor_rating`='".$rating."' WHERE  `editor_id`=".$aid	;

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

		$sql1 = "UPDATE `tolly_writer` SET `writer_name`='".$xname."', `writer_rate`='".$rate."', `writer_grade`='".$grade."', `writer_status`='".$status."', `writer_rating`='".$rating."' WHERE  `writer_id`=".$aid	;

	echo $sql1;



	$t = mysqli_query ( $conn, $sql1 );
	//echo $t;
	if ($t) {
		echo '<h1>'.$table.'    DATA UPDATED <h1>';
			
	} else {
		echo '<h1>ERROR';
	}
}



echo "<h2> <a href=\"javascript:history.back()\">Go Back</a> </h2>"




?>
