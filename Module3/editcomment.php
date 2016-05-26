<?php
    session_start(); 
    require 'database.php';
    
    $comment = $mysqli->real_escape_string($_POST['comment']);
    $id = $_POST[id];
    
    $stmt = $mysqli->prepare("update comments set comment=? where id=?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit();
    }
    $stmt->bind_param('si', $comment, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: comments.php?story=".$_POST['story']."&submit=");
    exit;
?>