<?php 
session_start();
include_once('../includes/connection.php');
if (isset($_SESSION['logged_in'])) {
	//if true, show admin index	
?>
	
	<html>
		<head>
			<title>
			Appointments
			</title>
		<link rel="stylesheet" href="../assets/login.css"/>
		</head>
		<body>
				<div class="login-container">
				<img src="../assets/images/logosq.png">
		<div class="login">
		

			<?php if (isset($error)) { ?>
			<div class="error"><?php echo $error; ?></div>
			<?php }?>
		<form action="login.php" method="post" autocomplete="off">
			<input type="text" name="username" placeholder="Username" />
			<input type="password" name="password" placeholder="Password" />
			<input type="submit" value="Login" id="submit"/>
		</form>
		<a href="#" class="login-link">Forgot your password?</a>
		</div>
</div>
		</body>
	</html>
	
<?php	
} else {
	header('Location: ../admin/login.php');	
	$error = 'You need to login!';
}
?>