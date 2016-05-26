<?php
	session_start();

	$filename = basename($_FILES['uploadedfile']['name']);
	if( !preg_match('/^[\w_\.\-]+$/', $filename) ){			#filtering
        echo "Invalid filename";						
        exit;
	}

	$username = $_SESSION['username'];
	if( !preg_match('/^[\w_\-]+$/', $username) ){			
        echo "Invalid username";
        exit;
	}

	$full_path = sprintf("/home/bflynn/Module2/shared/%s/%s", $username, $filename);

	if( move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $full_path) ){
        header("Location: userpage.php");
        exit;
	}else{
        header("Location: homepage.html");
        exit;
	}
?>
