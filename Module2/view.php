<?php
	session_start();
	$filepath = '/home/bflynn/Module2/shared/'.$_SESSION['username'].'/'.$_POST['downloadedfile'];
	if($_POST['View'] == 'View'){		#if we clicked view we then do this
		$finfo = new finfo(FILEINFO_MIME_TYPE);
		$mime = $finfo->file($filepath);
		header("Content-Type: ".$mime);
		readfile($filepath);
	}
	else{
		unlink($filepath);				#otherwise, we delete
		header("Location: userpage.php");
	}
?>
