<?php
// Connecting to database as mysqli_connect("hostname", "username", "password", "database name");
$con = mysqli_connect(
	getenv('DB_HOST'), 
	getenv('DB_USER'), 
	getenv('DB_PASSWD'), 
	getenv('DB_NAME')
);
?>
