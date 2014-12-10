<?php
$title = 'Confirmation';
include_once('includes/core.php'); 
include('includes/header.php');

$verify = $_GET['verify'];
if(isset($verify)){
	$query = "UPDATE users SET activated='1' WHERE activation_code='$verify'";
	$db->DoQueryz($query);
	echo $db->DoQuery($query);
	if(isset($verify) && $db->DoQuery($query) == TRUE){
		echo '<h1>Okay, It\'s been confirmed.</h1>';
		echo '<div>Your account is now active. You may now <a href="login.php">Log in</a></div>';
		}
	else{
 	 	echo "Some error occur.";
	}
}
?>

<h1>Okay, It's time to confirm.</h1>