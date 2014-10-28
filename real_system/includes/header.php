<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
?>

<html>
<head>
<title><?php echo "Business "; ?>Hello</title>
<link rel="stylesheet" href="<?php echo "assets/style.css";?>"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<div id="heading">
		<div id="branding">
		<a href="index.php">Concierge</a>
		</div>
		<div id="headingright">
		<?php
		// print_r ($_COOKIE);
		if (isset($_COOKIE['userdata'])) {
			if ($_COOKIE['userdata']['loggedin'] == 1) {

				echo 'Hello, <a href="manage_user.php">' . $_COOKIE['userdata']['forename'] . '</a>';
				echo ' (<a href="logout.php">Logout</a>)';
				// print_r($_COOKIE) . '<br>';
				// echo $_COOKIE['userdata']['forename'];
			};
		}
		?>
		</div>
	</div>
<div id="container">