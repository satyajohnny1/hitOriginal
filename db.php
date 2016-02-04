<?php
/*
$servername = "localhost";
$username = "root";
$password = "infy";
$dbname = "tolly_hit";



$servername = "mysql.hostinger.in";
$username = "u351245516_admin";
$password = "123abcABC@";
$dbname = "u351245516_hit";


*/


$servername = "mysql.hostinger.in";
$username = "u351245516_admin";
$password = "123abcABC@";
$dbname = "u351245516_hit";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}else{
	
}
