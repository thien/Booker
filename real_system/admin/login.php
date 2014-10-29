<?php 
include_once("../includes/core.php");
include("../functions/encryption.php");
echo dirname(__FILE__);
if (isset($_SESSION['logged_in'])) {
	header('Location: index.php');
} else {
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
	//show login
	if (isset($username, $_POST['password'])){
		$query = "SELECT * FROM admin WHERE username = :username AND password = :password";
		$query_params = array(
         ':username' => $username,
         ':password' => $password
      	);
		$db->DoQuery($query, $query_params);
		$num = $db->fetchAll();
		
		if ($num) {
			// //user entered correct details
			setcookie('admin[loggedin]', TRUE, $expiry, '', '', '', TRUE);
			setcookie('admin[username]', $username, $expiry, '', '', '', TRUE);
			header('Location: index.php');
			exit();
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
