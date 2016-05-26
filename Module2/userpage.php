<!doctype html>
<?php
	session_start();
	$username = $_SESSION['username'];
?>
<html>
	<head>
		<title><?php echo $username."'s Files"; ?></title>
		<meta charset="utf-8"/>
		<link rel="stylesheet" href="fileshare.css">
	</head>
	<body>
		<div id="content">
			<h3>
				<?php
				echo "Welcome, ". $username;
				?><br><span><a href="logout.php">Logout</a></span>
			</h3>
			<?php
				$userFiles = sprintf("/home/bflynn/Module2/shared/%s", $username);	#look in user's directory
				$files=scandir($userFiles);											#loop through and
				for ($i=0;$i<count($files);$i++) {									#display actions for each
					if($files[$i]!="." && $files[$i]!=".."){						#file
						echo sprintf('<form action="view.php" method="POST">
							 <input type="hidden" value=%s name="downloadedfile" />
							 <label for="download_file"> %s</label>
							 <input id="download_file" type="submit" name="View" value="View" />
							 <input type="submit" name="Delete" value="Delete"/>
							 </form>', htmlentities($files[$i]), htmlentities($files[$i]));
					}
				}
			?>
			<form enctype="multipart/form-data" action="uploadfile.php" method="POST">
				<p>
					<input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
					<label for="uploadfile_input">Choose a file to upload:</label> <input name="uploadedfile" type="file" id="uploadfile_input" />
				</p>		<!-- This code block is from the course php help page -->
				<p>
					<input type="submit" value="Upload File" />
				</p>
			</form>
		</div>
	</body>
</html>