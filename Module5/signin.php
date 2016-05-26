<!DOCTYPE html>

<html>
<head>
    <title>Sign-In</title>
</head>

<body>
	
    <form action="" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username"/>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password"/>
        <button type="submit" name="submit">Sign-In</button>
    </form>
	<p>
		New user? <a href="signup.php">Create a new account here!</a>
	</p>
	<p>
		For your password? We'll send you a link to reset! </p>
		<form action="change.php" method="POST">
			E-mail: <input type="text" name="email" size="20" /> <input type="submit" name="ForgotPassword" value=" Request Reset " />
		</form>
    <p>
    <?php
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			require 'database.php';
			 
			// Use a prepared statement
			$stmt = $mysqli->prepare("SELECT COUNT(*), id, crypted_password FROM users WHERE name=?");
			 
			// Bind the parameter
			$stmt->bind_param('s', $user);
			$user = $mysqli->real_escape_string($_POST['username']);
			$stmt->execute();
			 
			// Bind the results
			$stmt->bind_result($cnt, $user_id, $pwd_hash);
			$stmt->fetch();
			$stmt->close();
			$pwd_guess = $_POST['password'];
			// Compare the submitted password to the actual password hash
			if( $cnt == 1 && crypt($pwd_guess, $pwd_hash)==$pwd_hash){
				ini_set("session.cookie_httponly", 1);
				session_start();
				$_SESSION['user_id'] = $user;
				header("Location: calendar.php"); 
				exit();
			}else{
				echo "Login failed.....";
				exit();
			}
		}
    ?>
	</p>   
</body>
</html>
