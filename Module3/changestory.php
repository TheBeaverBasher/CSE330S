<?php
	session_start();
?>

<!DOCTYPE html>

<html>
<head>
    <title>Edit Story</title>
</head>

<body>
	<p>
		Edit your original story:
	</p>
	<h3>
		<?php
			echo htmlentities($_POST['title'])."...";
		?>
	</h3>
	<p>
		to...
	</p>
	<?php
		printf("<form action='editstory.php' method='POST'>
				<label for='username'>Title:</label>
				<input type='text' name='title' id='title'/>
				<label for='password'>Link:</label>
				<input type='text' name='link' id='link'/>
				<input type='hidden' name='id' id=%s value=%s>
				<input type='hidden' name='return' id=%s value=%s>
				<button type='submit' name='submit'>Submit!</button>
				</form>",
				htmlspecialchars($_POST[id]),
				htmlspecialchars($_POST[id]),
				htmlspecialchars($_POST[id]),
				htmlspecialchars($_POST['return']));
	?>
</body>
</html>