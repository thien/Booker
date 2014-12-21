<?php
// The message
include_once("includes/core.php");
include_once("functions/encryption.php");
function email($email, $username, $forename, $type, $extra = array()) {
$pin = encrypt($username);
$headers = "From: tits@snow.com";

if ($type == "confirm_registration") {
	$subject = 'Time to confirm your email';
	$message = "Hi $forename, \n\n
				You need to activate your account. Click the link below.\n\n";
	$message .= "http://projects.tnguyen.ch/comp4/confirmation.php?type=registration&value=$pin";}
if ($type == "forgotten_password") {
	if(isset($extra[":code"])) {
		$code = $extra[":code"];
	$subject = 'Forgotten Password request?';
	$message = "Hi $forename, \n\n
				You have requested to reset your password. Click the link below. \n\n";
	$message .= "http://projects.tnguyen.ch/comp4/confirmation.php?type=forgot&value=$code";}}
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
// Send
mail($email, $subject, $message, $headers);
}
?>