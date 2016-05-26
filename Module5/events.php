<?php
    ini_set("session.cookie_httponly", 1);
    session_start();
    if (isset($_SESSION['user_id'])) { 
		$_SESSION['loggedin'] = true;
	}
	else {
		$_SESSION['loggedin'] = false;
	}
    
    // List of events
    if ($_SESSION['loggedin']) {
        
        $user = $_SESSION['user_id'];
        
        $requete = "SELECT id, title, start, end FROM events WHERE username='" . $user . "' ORDER BY id";

        // connection to the database
        try {
        $bdd = new PDO('mysql:host=localhost;dbname=module5', 'root', 'Xboxlive1');
        } catch(Exception $e) {
         exit('Unable to connect to database.');
        }
        // Execute the query
        $resultat = $bdd->query($requete) or die(print_r($bdd->errorInfo()));
       
        // sending the encoded result to success page
        echo json_encode($resultat->fetchAll(PDO::FETCH_ASSOC));
   
    }
?>