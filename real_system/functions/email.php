<?php

function email($email, $user_id, $forename, $type, $extra = array()) {
	$headers = "From: robot@tnguyen.ch";
	if ($type == "confirm_registration") {
		if(isset($extra[":pin"])) {
			$pin = $extra[":pin"];
		$subject = 'Time to confirm your email';
		$message = "Hi $forename, \n\n You need to activate your account. Click the link below.\n\n";
		$message .= "http://projects.tnguyen.ch/confirmation.php?type=registration&value=$pin";} 
		else {
			echo "No pin is inserted.";
		}
	}
	if ($type == "forgotten_password") {
		if(isset($extra[":code"])) {
			$code = $extra[":code"];
			$subject = 'Forgotten Password request?';
			$message = "Hi $forename, \n\n You have requested to reset your password. Click the link below. \n\n";
			$message .= "http://projects.tnguyen.ch/confirmation.php?type=forgot&value=$code";
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
		$message = "Hi $forename, \n\n You need to activate your account. Click the link below. \n\n
					";
	}
	if ($type == "appointment") {
			if(isset($extra[":bookingday"]) & isset($extra[":bookingtime"]) & isset($extra[":bookingservice"])) {
			$booking_date = $extra[":bookingday"];
			$booking_time = $extra[":bookingtime"];
			$booking_service = $extra[":bookingservice"];
			$subject = 'Your Appointment';
			$message = "Hi $forename,\n\n You have an appointment at $booking_date, $booking_time for a $booking_service.";
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
			$message = "Hi $forename, \n\n Welcome to our company. Your new pin is $pin.";
				}
	}	
	$message .= "\n\n\n";
	$message .= "Nails Club\n";
	$message .= "128 Barking Road\n";
	$message .= "London\n";
	$message .= "E16 1EN\n";
// Send
mail($email, $subject, $message, $headers);
}
?>
