<!DOCTYPE html>

<html>
<head>
    <title>Sign-Up</title>
</head>

<body>
	
    <form action="" method="POST">
		<label for="email">Email:</label>
        <input type="email" name="email" id="email"/>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username"/>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password"/>
        <button type="submit" name="submit">Sign-Up</button>
    </form>
	<p>
		Already a user? <a href="signin.php">Log in here!</a>
	</p>
	<p>
	<?php
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			require 'database.php';
			 
			$username = $mysqli->real_escape_string($_POST['username']);
			$password = $_POST['password'];
			$email = $mysqli->real_escape_string($_POST['email']);
			
			$stmt1 = $mysqli->prepare("SELECT name, email_address from users where name=? or email_address=?");
			if(!$stmt1){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			
			$stmt1->bind_param('ss', $username, $email);
			$stmt1->execute();
			
			$stmt1->bind_result($nameExists, $emailExists);
			$stmt1->fetch();
			$stmt1->close();
			
			if($email==$emailExists) {
				echo "Looks like that email address already exists in our database, try another.";
				exit();
			}
			if($username==$nameExists) {
				echo  "Looks like that username already exists in our database, try another.";
				exit();
			}
			$stmt = $mysqli->prepare("INSERT INTO users (name, crypted_password, email_address) VALUES (?, ?, ?)");
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			 
			$password = crypt($password); 
			  
			$stmt->bind_param('sss', $username, $password, $email);
			 
			$stmt->execute();
			 
			$stmt->close();
			ini_set("session.cookie_httponly", 1);
			session_start();
			$_SESSION['user_id'] = $username;
			header("Location: calendar.php"); 
			exit();
		}
	?>
	</p>
</body>
</html>
