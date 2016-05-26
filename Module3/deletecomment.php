<?php
require 'database.php';

$stmt = $mysqli->prepare("delete from comments where id=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit();
}

$stmt->bind_param('i', $_POST[comment]);
$stmt->execute();
$stmt->close();

header("Location: comments.php?story=".$_POST[story]."&submit=");
exit;
?>
