<?php
	session_start();
?>

<!DOCTYPE html>

<html>
<head>
    <title>Edit Comment</title>
</head>

<body>
	<p>
		Edit your original comment:
	</p>
	<h3>
		<?php
			echo htmlentities($_POST[comment])."...";
		?>
	</h3>
	<p>
		to...
	</p>
	<?php
		printf("<form action='editcomment.php' method='POST'>
				<textarea rows='4' cols='50' name='comment'></textarea>
				<input type='hidden' name='id' id=%s value=%s>
				<input type='hidden' name='story' id=%s value=%s>
				<input type='submit'>
				</form>",
			htmlspecialchars($_POST[id]),
			htmlspecialchars($_POST[id]),
			htmlspecialchars($_POST[story]),
			htmlspecialchars($_POST[story]));
	?>
</body>
</html>