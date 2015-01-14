<?php 
$title = "Login";
$menutype = NULL;
include_once("../includes/core.php");
include("../functions/encryption.php");

if (isset($_GET['timeout'])){
	array_push($errors, 'You were logged out automatically for being inactive.');
}

if (isset($_SESSION['logged_in'])) {
	header('Location: index.php');
} else {
if (isset($_POST['username']) && (isset($_POST['password']))) {
		$username = trim($_POST['username']);
		$password = encrypt(trim($_POST['password']));
		$query = "SELECT * FROM admin WHERE username = :username AND password = :password";
		$query_parameters = array(
         ':username' => $username,
         ':password' => $password
      	);
		$db->DoQuery($query, $query_parameters);
		$num = $db->fetchAll();
		if ($num) {
			// //user entered correct details
			setcookie('admin[loggedin]', TRUE, $timeout, '', '', '', TRUE);
			header('Location: index.php');
			exit();
		} else {
			//user entered incorrect details
			array_push($errors, 'The username and password combination is not recognised. Please try again.');
		}					
}
include('../includes/header.php');
?>

		<h1>Login</h1>
	<form action="login.php" method="post" autocomplete="off">
		<input type="text" name="username" placeholder="Username" /><br>
		<input type="password" name="password" placeholder="Password" /><br>
		<input type="submit" value="Login" id="submit"/>
		<a href="/forgot.php" class="login-link">Forgot your password?</a>
	</form>
</div>

</div>
<?php
}
?>