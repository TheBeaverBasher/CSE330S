<?php
session_start(); 
require 'database.php';

$comment = $mysqli->real_escape_string($_POST['comment']);
$story = $_POST[story];
$user = $_SESSION['user_id'];

$stmt1 = $mysqli->prepare("select id, name from users where name=?");
if(!$stmt1){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	echo "userprob";
	exit;
}
$stmt1->bind_param('s', $user);
$stmt1->execute();

$stmt1->bind_result($userid, $username);
$stmt1->fetch();
$stmt1->close();
 
$stmt2 = $mysqli->prepare("insert into comments (comment, story, userid, username) values (?, ?, ?, ?)");
if(!$stmt2){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt2->bind_param('siis', $comment, $story, $userid, $username);
 
$stmt2->execute();
 
$stmt2->close();

header("Location: comments.php?story=".$story."&submit=");
exit();
 
?>
