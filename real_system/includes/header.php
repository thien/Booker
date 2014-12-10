<html>
<head>
<title>Concierge - <?php echo $title; ?></title>

<link rel="stylesheet" href="<?php echo $directory."assets/style.css";?>"/>
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="format-detection" content="telephone=yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="viewport" content="width=device-width, initial-scale=1">

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script type="text/javascript">
// Listen for ALL links at the top level of the document. For
// testing purposes, we're not going to worry about LOCAL vs.
// EXTERNAL links - we'll just demonstrate the feature.
$( document ).on(
    "click",
    "a",
    function( event ){
 
        // Stop the default behavior of the browser, which
        // is to change the URL of the page.
        event.preventDefault();
 
        // Manually change the location of the page to stay in
        // "Standalone" mode and change the URL at the same time.
        location.href = $( event.target ).attr( "href" );
    }
);
</script>
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

				echo 'Hello, <a href="profile.php">' . $_COOKIE['userdata']['forename'] . '</a>';
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
    <li><a href="calendar.php">Book Appointment</a></li>
    <li><a href="manage_appointments.php" class="active">Manage Appointments</a></li>
  </ul>
</header>



<?php };}; ?>