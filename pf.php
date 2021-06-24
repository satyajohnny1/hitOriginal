<?php
error_reporting(E_ERROR);
include 'db.php';
session_start(); // Starting Session

$uid =  $_SESSION['s_uid'];
$bal = $_SESSION['s_bal']; 
 
/** 
tolly_actor
tolly_actress
tolly_director
tolly_writer
tolly_music
tolly_cine
tolly_editor


UPDATE `tolly_actor` SET `pl`= (SELECT  ROUND(((SUM(sh.collection) - SUM(sh.budget))/10000000), 2) AS pl  FROM tolly_ready_for_shoot sh WHERE sh.aid=1 OR sh.a2=1 OR sh.a3=1)  WHERE  `actor_id`=1;
**/




 echo "--------------------------------------------------";
echo " <h3> ACTOR Table - Update </h3> ";
echo "--------------------------------------------------";


$sql = "SELECT distinct a.actor_id, a.actor_name FROM tolly_actor a ORDER BY a.actor_id";
$result = mysqli_query($conn, $sql);
 
if (mysqli_num_rows($result) > 0) {
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {	
		$id     =	$row["actor_id"];
		$name    =	$row["actor_name"];
		
		$plq = "UPDATE `tolly_actor` SET `pl`= (SELECT  ROUND(((SUM(sh.collection) - SUM(sh.budget))/10000000), 2) AS pl  FROM tolly_ready_for_shoot sh WHERE sh.aid=".$id." OR sh.a2=".$id." OR sh.a3=".$id." )  WHERE  `actor_id`=".$id ;
		
		
		$res = 	mysqli_query($conn, $plq);
		echo "<pre>".$id." - ".$name." Updated --> ".$res;
		
	}
}




 echo "--------------------------------------------------";
echo " <h3> ACTRESS Table - Update </h3> ";
echo "--------------------------------------------------";


$sql = "SELECT distinct a.actress_id, a.actress_name FROM tolly_actress a ORDER BY a.actress_id";
$result = mysqli_query($conn, $sql);
 
if (mysqli_num_rows($result) > 0) {
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {	
		$id     =	$row["actress_id"];
		$name    =	$row["actress_name"];
		
		$plq = "UPDATE `tolly_actress` SET `pl`= (SELECT  ROUND(((SUM(sh.collection) - SUM(sh.budget))/10000000), 2) AS pl  FROM tolly_ready_for_shoot sh WHERE sh.acid=".$id." OR sh.ac2=".$id." OR sh.ac3=".$id." )  WHERE  `actress_id`=".$id ;
		
		
		$res = 	mysqli_query($conn, $plq);
		echo "<pre>".$id." - ".$name." Updated --> ".$res;
		
	}
}




 echo "--------------------------------------------------";
echo " <h3> DIRECTOR Table - Update </h3> ";
echo "--------------------------------------------------";


$sql = "SELECT distinct a.director_id, a.director_name FROM tolly_director a ORDER BY a.director_id";
$result = mysqli_query($conn, $sql);
 
if (mysqli_num_rows($result) > 0) {
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {	
		$id     =	$row["director_id"];
		$name    =	$row["director_name"];
		
		$plq = "UPDATE `tolly_director` SET `pl`= (SELECT  ROUND(((SUM(sh.collection) - SUM(sh.budget))/10000000), 2) AS pl  FROM tolly_ready_for_shoot sh WHERE sh.did=".$id." OR sh.d2=".$id." OR sh.d3=".$id." )  WHERE  `director_id`=".$id ;
		
		
		$res = 	mysqli_query($conn, $plq);
		echo "<pre>".$id." - ".$name." Updated --> ".$res;
		
	}
}

 
 


 echo "--------------------------------------------------";
echo " <h3> WRITER Table - Update </h3> ";
echo "--------------------------------------------------";


$sql = "SELECT distinct a.writer_id, a.writer_name FROM tolly_writer a ORDER BY a.writer_id";
$result = mysqli_query($conn, $sql);
 
if (mysqli_num_rows($result) > 0) {
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {	
		$id     =	$row["writer_id"];
		$name    =	$row["writer_name"];
		
		$plq = "UPDATE `tolly_writer` SET `pl`= (SELECT  ROUND(((SUM(sh.collection) - SUM(sh.budget))/10000000), 2) AS pl  FROM tolly_ready_for_shoot sh WHERE sh.wid=".$id." OR sh.w2=".$id." OR sh.w3=".$id." )  WHERE  `writer_id`=".$id ;
		
		
		$res = 	mysqli_query($conn, $plq);
		echo "<pre>".$id." - ".$name." Updated --> ".$res;
		
	}
}






 echo "--------------------------------------------------";
echo " <h3> MUSIC Table - Update </h3> ";
echo "--------------------------------------------------";


$sql = "SELECT distinct a.music_id, a.music_name FROM tolly_music a ORDER BY a.music_id";
$result = mysqli_query($conn, $sql);
 
if (mysqli_num_rows($result) > 0) {
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {	
		$id     =	$row["music_id"];
		$name    =	$row["music_name"];
		
		$plq = "UPDATE `tolly_music` SET `pl`= (SELECT  ROUND(((SUM(sh.collection) - SUM(sh.budget))/10000000), 2) AS pl  FROM tolly_ready_for_shoot sh WHERE sh.mid=".$id." OR sh.m2=".$id." OR sh.m3=".$id." )  WHERE  `music_id`=".$id ;
		
		
		$res = 	mysqli_query($conn, $plq);
		echo "<pre>".$id." - ".$name." Updated --> ".$res;
		
	}
}




 echo "--------------------------------------------------";
echo " <h3> CINE Table - Update </h3> ";
echo "--------------------------------------------------";


$sql = "SELECT distinct a.cine_id, a.cine_name FROM tolly_cine a ORDER BY a.cine_id";
$result = mysqli_query($conn, $sql);
 
if (mysqli_num_rows($result) > 0) {
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {	
		$id     =	$row["cine_id"];
		$name    =	$row["cine_name"];
		
		$plq = "UPDATE `tolly_cine` SET `pl`= (SELECT  ROUND(((SUM(sh.collection) - SUM(sh.budget))/10000000), 2) AS pl  FROM tolly_ready_for_shoot sh WHERE sh.cid=".$id."  )  WHERE  `cine_id`=".$id ;
		
		
		$res = 	mysqli_query($conn, $plq);
		echo "<pre>".$id." - ".$name." Updated --> ".$res;
		
	}
}




 echo "--------------------------------------------------";
echo " <h3> editor Table - Update </h3> ";
echo "--------------------------------------------------";

$sql = "SELECT distinct a.editor_id, a.editor_name FROM tolly_editor a ORDER BY a.editor_id";
$result = mysqli_query($conn, $sql);
 
if (mysqli_num_rows($result) > 0) {
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {	
		$id     =	$row["editor_id"];
		$name    =	$row["editor_name"];
		
		$plq = "UPDATE `tolly_editor` SET `pl`= (SELECT  ROUND(((SUM(sh.collection) - SUM(sh.budget))/10000000), 2) AS pl  FROM tolly_ready_for_shoot sh WHERE sh.eid=".$id."  )  WHERE  `editor_id`=".$id ;
		
		
		$res = 	mysqli_query($conn, $plq);
		echo "<pre>".$id." - ".$name." Updated --> ".$res;
		
	}
}



 echo "--------------------------------------------------";
echo " <h3> User Table - Update </h3> ";
echo "--------------------------------------------------";

$sql = "SELECT distinct a.uid, a.username FROM tolly_user a ORDER BY a.uid";
$result = mysqli_query($conn, $sql);
 
if (mysqli_num_rows($result) > 0) {
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {	
		$id     =	$row["uid"];
		$name    =	$row["username"];
		
		$plq = "UPDATE `tolly_user` SET `pl`= (SELECT  ROUND(((SUM(sh.collection) - SUM(sh.budget))/10000000), 2) AS pl  FROM tolly_ready_for_shoot sh WHERE sh.uid=".$id."  )  WHERE  `uid`=".$id ;
		
		echo "<br> QUERY :".$plq;
		
		$res = 	mysqli_query($conn, $plq);
		echo "<pre>".$id." - ".$name." Updated --> ".$res;
		
	}
}
 
?>