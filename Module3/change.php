<?php
    require 'database.php';

    // Was the form submitted?
    if (isset($_POST["ForgotPassword"])) {
	
        // Harvest submitted e-mail address
        if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $email = $_POST["email"];
		
        }else{
            echo "email is not valid";
            exit;
        }

	// Check to see if a user exists with this e-mail
	$query = $mysqli->prepare('SELECT email_address FROM users WHERE email_address = ?');
	$query->bind_param('s', $email);
	$query->execute();
	$userExists = $query->fetch();
	$mysqli = null;
	
	if ($userExists)
	{
		// Create a unique salt. This will never leave PHP unencrypted.
		$salt = "498#2D83B631%3800EBD!801600D*7E3CC13";

		// Create the unique user password reset key
		$password = crypt($salt.$email);

		// Create a url which we will direct them to reset their password
		$pwrurl = "54.200.100.56/Module3/reset_password.php?q=".$password;
		
		// Mail them their key
		$mailbody = "Dear user,\n\nIf this e-mail does not apply to you please ignore it. It appears that you have requested a password reset at our
		website for CSE330's Module 3\n\nTo reset your password, please click the link below.
		If you cannot click it, please paste it into your web browser's address bar.\n\n" . $pwrurl . "\n\nThanks,\nThe Administration";
		mail($email, "CSE330 Module 3 - Password Reset", $mailbody);
		echo "Your password recovery key has been sent to your e-mail address.";
		
	}
	else
		echo "No user with that e-mail address exists.";
}
?>