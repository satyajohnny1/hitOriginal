<?php
require_once __DIR__ . '/env.php';

$servername = env('DB_HOST');
$dbname = env('DB_NAME');
$username = env('DB_USER');
$password = env('DB_PASS');
$dbport = (int) env('DB_PORT', '3306');

if ($servername === null || $dbname === null || $username === null || $password === null) {
	die("Database configuration missing. Check that .env exists at the project root with DB_HOST, DB_NAME, DB_USER, DB_PASS set.");
}

$conn = @mysqli_connect($servername, $username, $password, $dbname, $dbport);
if (!$conn) {
	echo "<h1> Database Connection failed. </h1>";
    die("Connection failed: " . mysqli_connect_error());
}
