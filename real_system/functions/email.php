<?php

function email($email, $username, $forename, $type, $extra = array()) {

$headers = "From: robot@tnguyen.ch";

if ($type == "confirm_registration") {
	if(isset($extra[":pin"])) {
		$pin = $extra[":pin"];
	$subject = 'Time to confirm your email';
	$message = "Hi $forename, \n\n
				You need to activate your account. Click the link below.\n\n";
	$message .= "http://projects.tnguyen.ch/comp4/confirmation.php?type=registration&value=$pin";} 
	else {
		echo "No pin is inserted.";
	}
}
if ($type == "forgotten_password") {
	if(isset($extra[":code"])) {
		$code = $extra[":code"];
		$subject = 'Forgotten Password request?';
		$message = "Hi $forename, \n\nYou have requested to reset your password. Click the link below. \n\n";
		$message .= "http://projects.tnguyen.ch/comp4/confirmation.php?type=forgot&value=$code";
	}
}
if ($type == "password_reset_confirmed") {
	if(isset($extra[":newpassword"])) {
		$newpassword = $extra[":newpassword"];
 		$subject = 'Your New Password.';
		$message = "Hi $forename, \n\n Your new password is: \n\n";
		$message .= "$newpassword";
	}
}
if ($type == "booking") {
	$subject = 'Time to confirm your booking';
	$message = "Hi $forename,
				You need to activate your account. Click the link below. \n\n
				";
}
if ($type == "appointment") {
		if(isset($extra[":bookingday"]) & isset($extra[":bookingtime"]) & isset($extra[":bookingservice"])) {
		$bookingdate = $extra[":bookingday"];
		$bookingtime = $extra[":bookingtime"];
		$bookingservice = $extra[":bookingservice"];
		$subject = 'Your Appointment';
		$message = "Hi $forename,
					You have an appointment at $bookingdate, $bookingtime for a $bookingservice.";
			}
}
if ($type == "new_pin") {
	if(isset($extra[":pin"])) {
		$pin = $extra[":pin"];
		$subject = 'Your New Pin';
		$message = "Hi $forename,
					Your new pin is $pin.";
			}
}
if ($type == "new_staff") {
	if(isset($extra[":pin"])) {
		$pin = $extra[":pin"];
		$subject = 'Welcome!';
		$message = "Hi $forename,
					Welcome to our company. Your new pin is $pin.";
			}
}	
// Send
mail($email, $subject, $message, $headers);
}
?>