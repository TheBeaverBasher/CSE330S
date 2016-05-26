<?php
	ini_set("session.cookie_httponly", 1);
    session_start();
    if (isset($_SESSION['user_id'])) { 
		$_SESSION['loggedin'] = true;
	}
	else {
		$_SESSION['loggedin'] = false;
	}
	$token = $_POST['token'];
	if($_SESSION['token'] !== $_POST['token']){
	die("Request forgery detected");
	}
	
	if ($_SESSION['loggedin']) {
		$id = $_POST['id'];
		try {
			$bdd = new PDO('mysql:host=localhost;dbname=module5', 'root', 'Xboxlive1');
			} catch(Exception $e) {
			exit('Unable to connect to database.');
			}
		 // update the records
		$sql = "DELETE FROM events WHERE id=".$id;
		$q = $bdd->prepare($sql);
		$q->execute();
	}
    
?>