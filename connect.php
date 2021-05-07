<?php

$servername = "sql208.unaux.com";
$username = "unaux_28553267";
$password = "123abcABC@";
$dbname = "unaux_28553267_javabo";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("<h1> Connection failed: \n <br>" . mysqli_connect_error());
}else{
	echo '<h1> Connection Success </h1>'
}
