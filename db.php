<?php
/*
 
## epizy
$servername = "sql105.epizy.com";
$dbname = "epiz_28768808_javabo";
$username = "epiz_28768808";
$password = "jEWDSrJkJi15f";


$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "hit2";

 DB_NAME', 'linkpro_wordpress' );

  'DB_USER', 'linkpro' );
 DB_PASSWORD', 'linkpro' );

 'DB_HOST', 'linkprotechcom.ipagemysql.com' );

*/





$servername = "sql105.epizy.com";
$dbname = "epiz_28768808_javabo";
$username = "epiz_28768808";
$password = "jEWDSrJkJi15f";



// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
	echo "<h1> Database Connection failed. </h1>";
    die("Connection failed: " . mysqli_connect_error());
}else{
	
}
