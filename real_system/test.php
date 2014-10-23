<?php 
include('includes/connection.php');

	//show login
	if (isset($_POST['username'], $_POST['password'])){
		$username = $_POST['username'];
		$password = $_POST['password'];
		if (empty($username) or empty($password)){
			$error = 'All fields are required!';
		} elseif (empty($username)){
		$error = 'Please enter a username!';
		} elseif (empty($password)){
		$error = 'Please enter a password!';
		} else {
			
			$barien = $pdo->prepare("SELECT activated FROM client WHERE username = ? and password = ?");
			$barien->bindValue(1, $username);
			$barien->bindValue(2, $password);
			$barien->execute();
			$num = $barien->rowCount();
			$result = $barien->fetch(PDO::FETCH_ASSOC);
			$val1 = 0;
			$val2 = 0;
			if ($num == 1) {
				$val1 = 1;
			} else {
				$val1 = 0;
			}
			if (strpos($result,'1') !== false) {
				$val2 = 1;
			} else { 
				$val2 = 0;
			}
			if ($val1 + $val2 = 2) {
				$error = "it works";
			} 
			if ($val1 = 1 and $val2 = 0) {
				$error = "you are not activated";
			} else {
				$error = "incorrect details bro"; 
			}
			}
			
		}		
	
	
?>
	
	<html>
		<head>
			<title>
			Login
			</title>
		</head>
		<body>
		
		<div class="login">
		
			<?php if (isset($error)) { ?>
			<div class="error"><?php echo $error; ?></div>
			<?php } ?>
		<form action="test.php" method="post" autocomplete="off">
			<input type="text" name="username" placeholder="Username" />
			<input type="password" name="password" placeholder="Password" />
			<input type="submit" value="Login" id="submit"/>
		</form>
		<a href="#" class="login-link">Forgot your password?</a>
		</div>

		</body>
	</html>

	