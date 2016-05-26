<?php
require 'database.php';

$stmt1 = $mysqli->prepare("delete from comments where story=?");
if(!$stmt1){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit();
}

$stmt1->bind_param('i', $_POST[story]);
$stmt1->execute();
$stmt1->close();

$stmt2 = $mysqli->prepare("delete from stories where id=?");
if(!$stmt2){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit();
}

$stmt2->bind_param('i', $_POST[story]);
$stmt2->execute();
$stmt2->close();

if($_POST['return']=='home'){
    header("Location: homepage.php");
    exit();    
}
else {
    header("Location: userpage.php?user=".$_POST['return']);
    exit();
}

?>
