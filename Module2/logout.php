<?php
	session_destroy();		#always destroy session upon logging out
	header('Location: homepage.html');	
	exit();
?>
