<?php 
			if (!$_COOKIE['userdata']['loggedin'] == 1) {
				header('Location: login.php');	
			};
include 'includes/header.php';



?>




<a href="calendar.php">Book an Appointment</a>
<a href="manage_appointments.php">Manage Appointments</a>
<?php 
include 'includes/footer.php';
?>