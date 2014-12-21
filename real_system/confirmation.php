<?php
$title = 'Confirmation';
include_once('includes/core.php'); 
include_once('functions/encryption.php');
include('functions/email.php');
include('includes/header.php');

if (isset($_GET['value'])){
$value = $_GET['value'];
}
if (isset($_GET['type'])){
$type = $_GET['type'];
}

if (isset($type)){
	if ($type == "registration"){
		if(isset($value)){
			$query = ("SELECT activation_code FROM users WHERE activation_code = :value");
			$query_params = array(':value' => $value);
			$db->DoQuery($query, $query_params);
			$rows = $db->fetch();
			if ($rows) {
				 $query = "UPDATE users SET activated = :key, activation_code = :newcode WHERE activation_code = :value";
				 $query_params = array(
				 ':key' => '1',
				 ':newcode' => NULL,
				 ':value' => $value
				 );
				 $db->DoQuery($query, $query_params);
			 	echo '<h1>Okay, It\'s been confirmed.</h1>';
			 	echo '<div>Your account is now active. You may now <a href="login.php">Log in</a>.</div>';	 	
			}else{
		 	 	echo "Sorry, We can't activate your account right now. You may want to try again.";
			}
		} else {
			echo "<h1>Okay, It's time to confirm.</h1>";
			echo "A email has been sent to confirm your registration.";
		}
	} elseif ($type == "confirmed"){
	echo "<h1>Okay, It's been confirmed.</h1>";
	echo '<A HREF="javascript:javascript:history.go(-1)">Click here to go back to previous page</A>';
	} elseif ($type == "forgot"){
		if (isset($value)){
			$query = ("SELECT forgot_code FROM users WHERE forgot_code = :value");
			$query_params = array(':value' => $value);
			$db->DoQuery($query, $query_params);
			$rows = $db->fetch();
			if ($rows) {
				$query = ("SELECT username, email, forename FROM users WHERE forgot_code = :value");
				$query_params = array(':value' => $value);
				$db->DoQuery($query, $query_params);
				$userdetails = $db->fetch();
				$newpassword = rand(100000, 999999);

				$extra = array(':newpassword' => $newpassword);
				email($userdetails['email'], $userdetails['username'], $userdetails['forename'], "password_reset_confirmed", $extra);

				$query = "UPDATE users SET password = :password, forgot_code = :blank WHERE forgot_code = :value";
				$query_params = array(
					':password' => encrypt($newpassword),
					':blank' => NULL,
					':value' => $value
				);
				$db->DoQuery($query, $query_params);
				
			 	echo '<h1>Okay, Its been sorted.</h1>';
			 	echo '<div>We\'e sent you a email  which contains your new password. Please change the password as soon as you <a href="login.php">Log in</a>.</div>';	 	
			}else{
				 	echo "We can't reset your password right now, Please try again.";
			}
		} else {
			echo '<h1>Okay, We\'ve sent you an email.</h1>';
			 	echo '<div>We\'e sent you a email containing further instructions.</div>';	
		}
	} elseif ($type == "appointment") {
		echo "<h1>Okay, Your appointment is confirmed.</h1>";

	echo 'Your appointment details are sent to your email address.';
	} elseif ($type == "updated") {
		echo "<h1>Okay, Your information is updated.</h1>";

	echo 'You can now continue with your day. :)';
	}
}
// header('Location: 404.php');
?>