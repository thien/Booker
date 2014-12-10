<?php 
$menutype = NULL;
include_once("../includes/core.php");
include("../functions/encryption.php");
if (isset($_SESSION['logged_in'])) {
	header('Location: index.php');
} else {
if (isset($_POST['username']) && (isset($_POST['password']))) {
		$username = trim($_POST['username']);
		$password = encrypt(trim($_POST['password']));
}
	//show login
	if (isset($username, $password)){
		$query = "SELECT * FROM users WHERE username = :username AND password = :password AND isadmin = 1";
		$query_params = array(
         ':username' => $username,
         ':password' => $password
      	);
		$db->DoQuery($query, $query_params);
		$num = $db->fetchAll();
		if ($num) {
			$query = "SELECT * FROM users WHERE username = :username AND activated = :activated";
			$query_params = array(
     	    ':username' => $username,
      	    ':activated' => '1'
     	 	);
			$db->DoQuery($query, $query_params);
			$num2 = $db->fetch();
			if ($num2) {
				$query = "SELECT forename, surname FROM users WHERE username = :username";
				$query_params = array(
				':username' => $username
				);
				$db->DoQuery($query, $query_params);
				$num2 = $db->fetch();
				$forename = $num2[0];
				$surname = $num2[1];
			// //user entered correct details
			setcookie('userdata[loggedin]', TRUE, $expiry, '', '', '', TRUE);
			setcookie('userdata[username]', $username, $expiry, '', '', '', TRUE);
			setcookie('userdata[forename]', $forename, $expiry, '', '', '', TRUE);
			setcookie('userdata[surname]', $surname, $expiry, '', '', '', TRUE);
			header('Location: index.php');
			exit();
			}
			else {
				$error = "You didn't activate your account!";
			}
		} else {
			//user entered incorrect details
			$error = 'Details were incorrect, try again!';
		}					
}
include('../includes/header.php');
?>



	
		<?php if (isset($error)) { ?>
		<div class="error"><?php echo $error; ?></div>
		<?php }?>
	<form action="login.php" method="post" autocomplete="off">
		<input type="text" name="username" placeholder="Username" /><br>
		<input type="password" name="password" placeholder="Password" /><br>
		<input type="submit" value="Login" id="submit"/>
		<a href="forgot.php" class="login-link">Forgot your password?</a>
	</form>
</div>

</div>
<?php
}
?>