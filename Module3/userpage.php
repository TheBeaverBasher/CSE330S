<!doctype html>
<?php
	session_start();
	$user = $_GET[user];
    if (!isset($_SESSION['loggedin'])) {
		$_SESSION['loggedin'] = false;
	}
?>
<html>
    <head>
        <title><?php echo htmlentities($user)."'s Story Submissions";?></title>
		<link rel="stylesheet" href="news.css">
    </head>
    <body>
		<div id="fixedheader">
	<h3>
		<?php
			if ($_SESSION['loggedin']) {
				echo "Welcome, <a href='userpage.php?user=".htmlentities($_SESSION['user_id'])."'>".htmlentities($_SESSION['user_id'])."</a>!
				<br><span><a href='logout.php'>Logout</a></span>";
				echo "<br><span><a href='homepage.php'>Front Page!</a></span><br>";
			}
			else { 
				echo "Welcome!<br><span><a href='signin.html'>Log in</a></span><br><span><a href='signup.html'>Create an account</a></span>";
				echo "<br><span><a href='homepage.php'>Front page</a></span>";				
			}
		?>
	</h3>
	</div>
		<div id="content">
        <?php
			require 'database.php';
			$stmt = $mysqli->prepare("select title, link, username, id, userid, posted from stories where username=? order by posted desc");
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				header("Location: underconstruction.html"); 
				exit();
			}
			$stmt->bind_param('s', htmlentities($user));
			$stmt->execute();
			$stmt->bind_result($title, $link, $username, $id, $userid, $posted);
			
			echo "<ol>\n";
			while($stmt->fetch()){
				printf("\t<li><a href=%s>%s</a><br>
					Submitted on %s<br>
					<form action='comments.php' method='GET'>
					<input type='hidden' name='story' id=%s value=%s>
					<button type='submit' name='submit'>Comments</button>
					</form>",
					htmlspecialchars($link),
					htmlspecialchars($title),
					htmlspecialchars($posted),
					htmlspecialchars($id),
					htmlspecialchars($id)
					);
			if ($_SESSION['user_id']===$user) {
				printf("<form action='changestory.php' method='POST'>
						<input type='hidden' name='id' id=%s value=%s>
						<input type='hidden' name='title' id=%s value=%s>
						<input type='hidden' name='link' id=%s value=%s>
						<input type='hidden' name='return' id=%s value='%s'>
						<button type='submit' name='submit'>Edit</button></form>",
						htmlspecialchars($id),
						htmlspecialchars($id),
						htmlspecialchars($id),
						htmlentities($title),
						htmlspecialchars($id),
						htmlentities($link),
						htmlspecialchars($id),
						htmlentities($username));
				printf("<form action='deletestory.php' method='POST'>
					<input type='hidden' name='story' id=%s value=%s>
					<input type='hidden' name='return' id=%s value='%s'>
					<button type='submit' name='submit'>Delete</button>",
					htmlspecialchars($id),
					htmlspecialchars($id),
					htmlspecialchars($id),
					htmlentities($username));
			}
			printf("</li>\n");
		}
		echo "</ol>\n";
		?>
		</div>
    </body>
</html>
