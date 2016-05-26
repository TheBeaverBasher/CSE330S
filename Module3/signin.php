<?php
 
require 'database.php';
 
// Use a prepared statement
$stmt = $mysqli->prepare("SELECT COUNT(*), id, crypted_password FROM users WHERE name=?");
 
// Bind the parameter
$stmt->bind_param('s', $user);
$user = $mysqli->real_escape_string($_POST['username']);
$stmt->execute();
 
// Bind the results
$stmt->bind_result($cnt, $user_id, $pwd_hash);
$stmt->fetch();
$stmt->close();
$pwd_guess = $_POST['password'];
// Compare the submitted password to the actual password hash
if( $cnt == 1 && crypt($pwd_guess, $pwd_hash)==$pwd_hash){
	session_start();
	$_SESSION['user_id'] = $user;
	header("Location: homepage.php"); 
	exit();
}else{
	echo "Login failed.....";
	exit();
}
?>
