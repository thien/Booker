<?php 
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
			// //user entered correct details
			setcookie('admin[loggedin]', TRUE, $admin_expiry, '', '', '', TRUE);
			header('Location: index.php');
			exit();
			
		} else {
			//user entered incorrect details
			$error = 'Details were incorrect, try again!';
		}					
}
include('../includes/header.php');
display_errors($errors);
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