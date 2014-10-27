<?php 
session_start();
include_once("includes/common.php");
if (isset($_SESSION['logged_in'])) {
	//if true, show admin index
	header('Location: index.php');	
} else {
	//show login
	if (isset($_POST['username'], $_POST['password'])){
		$query = "SELECT * FROM client WHERE username = :username AND password = :password";
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



<div id="left">
	<h1>New here?</h1>
	<p>You'll need an account to book an appointment. Registration will open in a new window. You can come when you have registered!</p>
	<a href="register.php"><button type="register">Register</button></a>
</div>
	<div class="verticalLine"></div>
<div id="right">
	<h1>Have an account?</h1>
	
		<?php if (isset($error)) { ?>
		<div class="error"><?php echo $error; ?></div>
		<?php }?>
	<form action="login.php" method="post" autocomplete="off">
		<input type="text" name="username" placeholder="Username" /><br>
		<input type="password" name="password" placeholder="Password" /><br>
		<input type="submit" value="Login" id="submit"/>
		<a href="#" class="login-link">Forgot your password?</a>
	</form>
</div>

</div>
<?php
}
?>