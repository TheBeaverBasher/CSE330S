<?php
// Content of database.php
 
$mysqli = new mysqli('localhost', 'mod3', 'password123', 'module3');
 
if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>