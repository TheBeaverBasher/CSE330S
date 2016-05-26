<?php
	session_start();
	if (!isset($_SESSION['loggedin'])) {
		$_SESSION['loggedin'] = false;
	}
?>

<!DOCTYPE html>

<html>
<head>
    <title>Submit Story</title>
</head>

<body>
	<?php
		if ($_SESSION['loggedin']) {
			printf("<form action='submitstory.php' method='POST'>
				<label for='title'>Title:</label>
				<input type='text' name='title' id='title'/>
				<label for='link'>Link:</label>
				<input type='text' name='link' id='link'/>
				<button type='submit' name='submit'>Submit!</button>
			</form>");
		}
		else {
			printf("<p>You must be logged in to submit a story!</p>");
		}
	?>
</body>
</html>
