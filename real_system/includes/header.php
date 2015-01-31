<?php


  if (file_exists($directory . "setup.php")) {
   	$company_name = "Booker";
  } else {
		$query = "SELECT value FROM metadata WHERE id = 5";
		$db->DoQuery($query);
		$value = $db->fetch();
		$company_name = $value[0];
		$query = "SELECT value FROM metadata WHERE id = 6";
		$db->DoQuery($query);
		$value = $db->fetch();
		$slogan = $value[0];
	}

?>

<html>
<!DOCTYPE HTML>
      <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title><?php echo $company_name;?> - <?php echo $title; ?></title>
<link rel="stylesheet" href="<?php echo $directory."assets/style.css";?>">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="format-detection" content="telephone=yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="viewport" content="width=device-width, initial-scale=1">

<script src="../assets/jquery.js"></script>
<script src="../assets/jqueryui.js"></script>
<script type="text/javascript">
	// Listen for ALL links at the top level of the document. For
	// testing purposes, we're not going to worry about LOCAL vs.
	// EXTERNAL links - we'll just demonstrate the feature.
	$( document ).on(
	    "click",
	    "a",
	    if(window.location.contains("?month=")){
	    function( event ){
	 
	        // Stop the default behavior of the browser, which
	        // is to change the URL of the page.
	        event.preventDefault();
	 
	        // Manually change the location of the page to stay in
	        // "Standalone" mode and change the URL at the same time.
	        location.href = $( event.target ).attr( "href" );
	    }}
	);
</script>
</head>
<body>
	<div id="heading">
		<div id="branding">

		<a href="index.php"><?php echo $company_name;?></a>
		<div id="slogan"><?php if (isset($slogan)){echo $slogan;}?></div>
		</div>
		<?php
		if (strpos($_SERVER['SCRIPT_NAME'],'admin') !== false){
			echo 'A';
		} elseif (strpos($_SERVER['SCRIPT_NAME'],'staff') !== false){
			echo 'S';
		}
		?>
		<div id="headingright">
		<?php
		// print_r ($_COOKIE);

		if (isset($_COOKIE['userdata'])) {
			if (!strpos($_SERVER['SCRIPT_NAME'],'staff')){
				if ($_COOKIE['userdata']['loggedin'] == 1) {
					echo 'Hello, <a href="profile.php">' . $_COOKIE['userdata']['forename'] . '</a>';
					echo ' (<a href="logout.php">Logout</a>)';
				};
			}
		} elseif (isset($_COOKIE['admin']['loggedin'])){
			 if ($_COOKIE['admin']['loggedin'] == 1) {
				echo 'Hello, <b>Administrator</b>';
				echo ' (<a href="logout.php">Logout</a>)';
			}
		}
		?>
		</div>
	</div>
<div id="container">

<?php
display_errors($errors);
display_updates($update);

if (isset($menutype)) {
if ($menutype == "user_dashboard") { ?>

<header>
  <ul>
    <li><a href="calendar.php" <?php if ($title == 'Book Appointment'){echo "class='active'";};?>>Book Appointment</a></li>
    <li><a href="manage_appointments.php" <?php if ($title == 'Manage Appointments'){echo "class='active'";};?>>Manage Appointments</a></li>
  </ul>
</header>

<?php 
};
if ($menutype == "admin_dashboard"){?>
<header>
	<ul>
		<li><a href="index.php" <?php if ($title == 'Dashboard'){echo "class='active'";};?>>Dashboard</a></li>
		<li><a href="appointments.php" <?php if ($title == 'Appointments'){echo "class='active'";};?>>Appointments</a></li>
		<li><a href="calendar.php" <?php if ($title == 'Calendar'){echo "class='active'";};?>>Calendar</a></li>
		<li><a href="services.php" <?php if ($title == 'Services'){echo "class='active'";};?>>Services</a></li>
		<li><a href="users.php" <?php if ($title == 'Users'){echo "class='active'";};?>>Users</a></li>
		<li><a href="settings.php" <?php if ($title == 'Settings'){echo "class='active'";};?>>Settings</a></li>
	</ul>
</header>
<?php
};};
?>