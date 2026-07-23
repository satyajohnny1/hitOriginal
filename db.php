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




/* JavaBo
$servername = "sql301.epizy.com";
$dbname = "epiz_32875882_javabo";
$username = "epiz_32875882";
$password = "AF6tE0XjpZUX";
*/

//mizDb
$servername = "68.178.135.125";
$dbname = "testdb";
$username = "testdb";
$password = "testdb";

 


// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
	echo "<h1> Database Connection failed. </h1>";
    die("Connection failed: " . mysqli_connect_error());
}else{
	//echo "<h1> Connection Success. </h1>";
}
