<?php
    session_start(); 
    require 'database.php';
    
    $title = $mysqli->real_escape_string($_POST['title']);
    $link = $mysqli->real_escape_string($_POST['link']);
    $id = $_POST[id];
    $user = $_SESSION['user_id'];
    
    $stmt = $mysqli->prepare("update story set title=?, link=? where id=?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit();
    }
    $stmt->bind_param('ssi', $title, $link, $id);
    $stmt->execute();
    $stmt->close();
    
    if($_POST['return']=='home'){
        header("Location: homepage.php");
        exit();    
    }
    else {
        header("Location: userpage.php?user=".$_POST['return']);
        exit();
    }
?>