<?php
	session_start();	
	session_destroy();		#always destroy session upon logging out
	header('Location: calendar.php');	
	exit();
?>
