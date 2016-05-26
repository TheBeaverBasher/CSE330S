<!doctype html>
<?php
	session_start();
	if (!isset($_SESSION['loggedin'])) {
		$_SESSION['loggedin'] = false;
	}
?>

<html>
<head>
    <title>Comments</title>
	<link rel="stylesheet" href="news.css">	
</head>

<body>
	<div id="fixedheader">
	<h3>
		<?php
			if ($_SESSION['loggedin']) {
				echo "Welcome, <a href='userpage.php?user=".htmlentities($_SESSION['user_id'])."'>".htmlentities($_SESSION['user_id'])."</a>!
				<br><span><a href='logout.php'>Logout</a></span>";
				echo "<br><span><a href='homepage.php'>Front page</a></span><br>";
			}
			else { 
				echo "<span><a href='signin.html'>Log in</a></span><br><span><a href='signup.html'>Create an account</a></span>";
				echo "<br><span><a href='homepage.php'>Front page</a></span>";
			}
		?>
	</h3>
	</div>
	<div id="content">
    <?php
        require 'database.php';
        $stmt = $mysqli->prepare("select comment, userid, username, id, posted from comments where story=? order by posted");
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			header("Location: underconstruction.html"); 
			exit();
		}
        $story = $_GET[story];
        $stmt->bind_param('i', $story);
		$stmt->execute();
		$stmt->bind_result($comment, $userid, $username, $id, $posted);
		
		echo "<ul>\n";
		while($stmt->fetch()){
			printf("\t<li> %s <br>
				   Submitted by <a href='userpage.php?user=%s'>%s</a> on %s
				   </li>\n",
				   htmlentities($comment),
				   htmlentities($username),
				   htmlentities($username),
				   htmlspecialchars($posted)
			);
			if ($_SESSION['user_id']===$username) {
				printf("<form action='changecomment.php' method='POST'>
						<input type='hidden' name='comment' id=%s value=%s>
						<input type='hidden' name='id' id=%s value=%s>
						<input type='hidden' name='story' id=%s value=%s>
						<button type='submit' name='submit'>Edit</button></form>",
						htmlspecialchars($id),
						htmlentities($comment),
						htmlspecialchars($id),
						htmlspecialchars($id),
						htmlspecialchars($story),
						htmlspecialchars($story));
				printf("<form action='deletecomment.php' method='POST'>
					<input type='hidden' name='comment' id=%s value=%s>
					<input type='hidden' name='story' id=%s value=%s>
					<button type='submit' name='submit'>Delete</button></form>",
					htmlspecialchars($id),
					htmlspecialchars($id),
					htmlspecialchars($story),
					htmlspecialchars($story));
			}
			printf("</li>\n");
		}
		echo "</ul>\n";
 
		$stmt->close();		
		
		if ($_SESSION['loggedin']) {
			printf("<p>Leave a comment!<p>
				   <form action='submitcomment.php' method='POST'>
				   <textarea rows='4' cols='50' name='comment' >Enter comment here...</textarea>
				   <input type='hidden' name='story' id=%s value=%s>
				   <input type='submit'>
				   </form>",
				   htmlspecialchars($story),
				   htmlspecialchars($story));
		}
		else {
			printf("<p>To leave a comment, you must log in!</p>");
		}
	?>
	</div>
</body>
</html>
