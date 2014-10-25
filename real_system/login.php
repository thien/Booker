<?php 

session_start();
include_once("includes/common.php");
if (isset($_SESSION['logged_in'])) {
	//if true, show admin index
	header('Location: index.php');	
	
} else {
	//show login
	if (isset($_POST['username'], $_POST['password'])){
		$salt = '$+;$]d>;3)#77.';
		$username = $_POST['username'];
		$password = $_POST['password'];
		if (empty($username) or empty($password)){
			$error = 'All fields are required!';
		} elseif (empty($username)){
		$error = 'Please enter a username!';
		} elseif (empty($password)){
		$error = 'Please enter a password!';
		} else {
			$query = "SELECT * FROM client WHERE username = :username AND password = :password";
			$query_params = array(
          	':username' => $_POST['username'],
         	':password' => $password
      		);
			$db->DoQuery($query, $query_params);

			$num = $db->fetch();
			if ($num == 1) {
				//user entered correct details
				$_SESSION['logged_in'] = true;
				header('Location: index.php');
				exit();
			} else {
				//user entered incorrect details
				$error = 'Details were incorrect, try again!';
			}
		}
							
	}
	?>
	
	<html>
		<head>
			<title>
			Login
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
}
?>



<!-- 
function generateHash($password) {
    if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
        $salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
        return crypt($password, $salt);
    }
}http://www.sitepoint.com/password-hashing-in-php/

function verify($password, $hashedPassword) {
    return crypt($password, $hashedPassword) == $hashedPassword;
} -->