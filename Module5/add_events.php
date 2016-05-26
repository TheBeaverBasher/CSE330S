<?php
	ini_set("session.cookie_httponly", 1);
    session_start();
    if (isset($_SESSION['user_id'])) { 
		$_SESSION['loggedin'] = true;
	}
	else {
		$_SESSION['loggedin'] = false;
	}
    // Values received via ajax
    $title = real_escape_string($_POST['title']);
    $start = $_POST['start'];
    $end = $_POST['end'];
	$token = $_POST['token'];
	if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
	}
    
    if ($_SESSION['loggedin']) {
        $user = real_escape_string($_SESSION['user_id']);
        // connection to the database
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=module5', 'root', 'Xboxlive1');
            } catch(Exception $e) {
            exit('Unable to connect to database.');
            }
    
		// insert the records
		$sql = "INSERT INTO events (title, start, end, username) VALUES (:title, :start, :end, :user)";
		$q = $bdd->prepare($sql);
		$q->execute(array(':title'=>$title, ':start'=>$start, ':end'=>$end, ':user'=>$user));
    }
?>