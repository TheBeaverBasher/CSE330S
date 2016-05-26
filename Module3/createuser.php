<?php
require 'database.php';
 
$username = $mysqli->real_escape_string($_POST['username']);
$password = $_POST['password'];
$email = $mysqli->real_escape_string($_POST['email']);

$stmt1 = $mysqli->prepare("select name, email_address from users where name=? or email_address=?");
if(!$stmt1){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt1->bind_param('ss', $username, $email);
$stmt1->execute();

$stmt1->bind_result($nameExists, $emailExists);
$stmt1->fetch();
$stmt1->close();

if($email==$emailExists) {
	echo "Looks like that email address already exists in our database, try another.";
	exit();
}
if($username==$nameExists) {
	echo  "Looks like that username already exists in our database, try another.";
	exit();
}
$stmt = $mysqli->prepare("insert into users (name, crypted_password, email_address) values (?, ?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$password = crypt($password); 
  
$stmt->bind_param('sss', $username, $password, $email);
 
$stmt->execute();
 
$stmt->close();
session_start();
$_SESSION['user_id'] = $username;
header("Location: homepage.php"); 
exit();
 
?>
