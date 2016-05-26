<?php
	ini_set("session.cookie_httponly", 1);
    session_start();
    if (isset($_SESSION['user_id'])) { 
		$_SESSION['loggedin'] = true;
	}
	else {
		$_SESSION['loggedin'] = false;
	}
    
    /* Values received via ajax */
    $id = $_POST['id'];
    $title = real_escape_string($_POST['title']);
    $start = $_POST['start'];
    $end = $_POST['end'];
	$token = $_POST['token'];
	if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
	}
    
	if ($_SESSION['loggedin']) {
		// connection to the database
		try {
			$bdd = new PDO('mysql:host=localhost;dbname=module5', 'root', 'Xboxlive1');
			} catch(Exception $e) {
			exit('Unable to connect to database.');
			}
		 // update the records
		$sql = "UPDATE events SET title=?, start=?, end=? WHERE id=?";
		$q = $bdd->prepare($sql);
		$q->execute(array($title,$start,$end,$id));
	}
?>