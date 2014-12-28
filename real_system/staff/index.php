<?php 
$title = "Staff Login";
include("../includes/core.php");
include("../functions/encryption.php");
if (isset($_COOKIE['staff']['logged_in'])) {
	//if true, show admin index
	header('Location: appointments.php');
} else {
	if (isset($_GET['timeout'])){
		array_push($errors, 'You were logged out automatically for being inactive.');
	}
	//show login
	if (isset($_POST['pin'])){
		$pin = $_POST['pin'];
		if (strlen($pin) < 2){
			$error = 'You need to type in your PIN!';
		} else {
			$pin = encrypt($_POST['pin']);
			$query = "SELECT * FROM staff WHERE pin = :pin";
			$query_params = array(':pin' => $pin);
				$db->DoQuery($query, $query_params);
				$num = $db->fetchAll();
			if ($num) {
				//user entered correct details
				// echo "<pre>";
				// print_r($num);
				// echo "</pre>";
				$staff_expiry = time() + 10;
				setcookie('staff[loggedin]', TRUE, $staff_expiry, '', '', '', TRUE);
				setcookie('staff[id]', $num[0]['id'], $staff_expiry, '', '', '', TRUE);
				setcookie('staff[forename]', $num[0]['s_forename'], $staff_expiry, '', '', '', TRUE);
				setcookie('staff[surname]', $num[0]['s_surname'], $staff_expiry, '', '', '', TRUE);

				header('Location: appointments.php');
				exit();
			} else {
				//user entered incorrect details
				array_push($errors, 'Details were incorrect, try again!');
			}
		}					
	}
	include("../includes/header.php");
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
		

			<?php 
			display_errors($errors);
			 
			 ?>
			<h1>Enter Your Pin</h1>
		<form action="index.php" method="post" autocomplete="off">
			<input type="tel" min="5" max="5" name="pin" placeholder="pin" />
			<button type="submit">Enter</button>
		</form>
		</div>
</div>
		</body>
		
	</html>
	
<?php
}
?>