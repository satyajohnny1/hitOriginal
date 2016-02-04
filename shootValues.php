<?php
include 'db.php';

$sql = "select * from tolly_user a where a.email = '$email'";
$result = mysqli_query ( $conn, $sql );

if (mysqli_num_rows ( $result ) > 0) {
	echo "<h1>$email</h1>  already in use. Try to Login .If not Verify, Verify the email now ";
}

?>