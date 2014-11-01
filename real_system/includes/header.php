
<html>
<head>
<title><?php echo "Business "; ?>Hello</title>
<link rel="stylesheet" href="<?php echo $directory."assets/style.css";?>"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<div id="heading">
		<div id="branding">
		<a href="<?php echo $directory; ?>">Concierge</a>
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

<?php
if (isset($menutype)) {
if ($menutype == "user_dashboard") { ?>

<header>
  <ul>
    <li><a href="calendar.php">Make New Appointment</a></li>
    <li><a href="manage_appointments.php" class="active">Manage</a></li>
    <li><a href="manage_user.php">Settings</a></li>
  </ul>
</header>



<?php };}; ?>