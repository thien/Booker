<?php 
$title = 'Forgot Password?';
session_start();
include_once("includes/core.php");

	//show login
	if (isset($_POST['email'])){
		$query = "SELECT * FROM users WHERE username = :username AND password = :password";
		$query_params = array(
         ':username' => $_POST['username'],
         ':password' => $_POST['password']
      	);
		$db->DoQuery($query, $query_params);
		$num = $db->fetchAll();
		if ($num) {
			//user entered correct details
			$_SESSION['logged_in'] = true;
			header('Location: index.php');
			exit();
		} else {
			//user entered incorrect details
			$error = 'Details were incorrect, try again!';
		}					
}
include('includes/header.php');
?>



	<h1>Forgot your password?</h1>
	You can reset your password by typing in the email associated with your account.
	
		<?php if (isset($error)) { ?>
		<div class="error"><?php echo $error; ?></div>
		<?php }?>
	<form action="confirmation.php" method="post" autocomplete="off">
		<input type="text" name="email" placeholder="email" /><br>
		<input type="submit" value="Next" id="submit"/>
	</form>

</div>