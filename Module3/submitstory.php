<?php
session_start(); 
require 'database.php';

$title = $mysqli->real_escape_string($_POST['title']);
$link = $mysqli->real_escape_string($_POST['link']);
$user = $_SESSION['user_id'];

$stmt1 = $mysqli->prepare("select id, name from users where name=?");
if(!$stmt1){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt1->bind_param('s', $user);
$stmt1->execute();

$stmt1->bind_result($userid, $username);
$stmt1->fetch();
$stmt1->close();
 
$stmt2 = $mysqli->prepare("insert into stories (title, link, userid, username) values (?, ?, ?, ?)");
if(!$stmt2){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt2->bind_param('ssis', $title, $link, $userid, $username);
 
$stmt2->execute();
 
$stmt2->close();

$_SESSION['user_id'] = $username;
header("Location: homepage.php"); 
exit();
 
?>
