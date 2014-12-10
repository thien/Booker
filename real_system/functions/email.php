<?php
// The message
function email($email, $username, $forename, $type) {
$pin = md5($salt . $username);
$headers = "From: robot@tnguyen.ch";
if ($type == "confirm_registration") {
	$subject = 'Time to confirm your email';
	//$message = "This is an automated message\r\nLine 2\r\nLine 3";
	
	// In case any of our lines are larger than 70 characters, we should use wordwrap()
	$message = wordwrap($message, 70, "\r\n");
	$message = "Hi $forename,
				You need to activate your account. Click the link below.";
	$message .= "http://projects.tnguyen.ch/comp4/confirm.php?verify=$pin";
}
if ($type == "forgotten_password") {
	$subject = 'Forgotten Password request?';
	$message = wordwrap($message, 70, "\r\n");
	$message = "Hi $forename,
				You need to activate your account. Click the link below.
				";
}

if ($type == "booking") {
	$subject = 'Time to confirm your booking';
	$message = wordwrap($message, 70, "\r\n");
	$message = "Hi $forename,
				You need to activate your account. Click the link below.
				";
}
		
// Send
mail($email, $subject, $message, $headers);
}
?>