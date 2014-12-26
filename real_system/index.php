<?php 
$title = 'Home';
if (!$_COOKIE['userdata']['loggedin'] == 1) {
	header('Location: login.php');
};
include_once('includes/core.php'); 
include 'includes/header.php';
?>
<div id="group">
<div id="left"><div class="bigbox"><a href="calendar.php">Book an Appointment</a></div></div>
<div id="right"><div class="bigbox"><a href="manage_appointments.php">Manage Appointments</a></div></div>
</div>
<?php 
include 'includes/footer.php';
?>