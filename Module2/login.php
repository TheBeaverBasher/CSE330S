<?php
	$username = $_POST['username'];
	$h = fopen("/home/bflynn/Module2/users.txt", "r"); #location of my users
	while( !feof($h) ){ #loop through to find user name
		$name = trim(fgets($h)); 
		if($username == $name){
			session_start();
			$_SESSION['username'] = $username;
			fclose($userFile);
			header("Location: userpage.php"); #go to that user's page
			exit();
		}
	}
?>
