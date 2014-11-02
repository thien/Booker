<?php
// The message
function email($email, $username, $forename, $type) {
$headers = "From: robot@tnguyen.ch";
if ($type == "confirm_registration") {
	$subject = 'Time to confirm your email'.
	//$message = "This is an automated message\r\nLine 2\r\nLine 3";
	
	// In case any of our lines are larger than 70 characters, we should use wordwrap()
	$message = wordwrap($message, 70, "\r\n");
	$message = "Hi "..",
				You need to activate your account. Click the link below.
				";
}
if ($type == "forgotten_password") {
	$subject = 'Time to confirm your email'.
	$message = wordwrap($message, 70, "\r\n");
	$message = "Hi "..",
				You need to activate your account. Click the link below.
				";
}

if ($type == "booking") {
	$subject = 'Time to confirm your email'.
	$message = wordwrap($message, 70, "\r\n");
	$message = "Hi "..",
				You need to activate your account. Click the link below.
				";
}
		
// Send
mail($email, $subject, $message, $headers);
}
email("thien.nguyen@gmail.com");
?>