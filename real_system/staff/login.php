<?php 
  include("../classes/database.php");

  $db = new database;
  $db->initiate();
if (isset($_SESSION['logged_in'])) {
	//if true, show admin index
	header('Location: index.php');	
	
} else {
	//show login
	if (isset($_POST['pin'])){
		$pin = $_POST['pin'];
		if (empty($pin)){
			$error = 'You need to type in your PIN!';
		} else {
			$query = "SELECT * FROM staff WHERE pin = :pin";
			$query_params = array(
			 ':pin' => $pin
				);
				$db->DoQuery($query, $query_params);
				$num = $db->fetchAll();
			if ($num) {
				//user entered correct details
				// echo "<pre>";
				// print_r($num);
				// echo "</pre>";
				setcookie('staff[loggedin]', TRUE, $expiry, '', '', '', TRUE);
				setcookie('staff[username]', $num[0]['username'], $expiry, '', '', '', TRUE);
				setcookie('staff[id]', $num[0]['id'], $expiry, '', '', '', TRUE);
				setcookie('staff[forename]', $num[0]['s_forename'], $expiry, '', '', '', TRUE);
				setcookie('staff[surname]', $num[0]['s_surname'], $expiry, '', '', '', TRUE);

				// print_r($_COOKIE);
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
		<div class="login">
		

			<?php if (isset($error)) { ?>
			<div class="error"><?php echo $error; ?></div>
			<?php }?>
			<h1>Enter Your Pin</h1>
		<form action="login.php" method="post" autocomplete="off">
			<input type="pin" name="pin" placeholder="pin" />
		</form>
		</div>
</div>
		</body>
	</html>
	
<?php
}
?>