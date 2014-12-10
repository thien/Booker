<?php 
include_once("../includes/core.php");
include($directory . "/functions/encryption.php");
include($directory . '/includes/header.php');

//Calculating Number of Bookings Monthly
$startmonth = date("Y-m") . "-01";
$endmonth = date("Y-m") . "-31";
$r = "SELECT COUNT(*) FROM booking WHERE date >='$startmonth' AND date <='$endmonth'";
$db->DoQuery($r);
$monthly_bookings = $db->fetch();

//Calculating Number of Bookings Daily
$today = date("Y-m-d");
$a = "SELECT COUNT(*) FROM booking WHERE date ='$today'";
$db->DoQuery($a);
$daily_bookings = $db->fetch();

//Calculating Revenue from monthly bookings
$startmonth = date("Y-m") . "-01";
$endmonth = date("Y-m") . "-31";
$l = "SELECT sum(service.price) FROM booking INNER JOIN service ON booking.service_id=service.id WHERE date >='$startmonth' AND date <='$endmonth'";
$db->DoQuery($l);
$monthly_revenue = $db->fetch();

// Calculating Number of Accounts
$q = "SELECT COUNT(*) FROM users";
$db->DoQuery($q);
$registered_accounts = $db->fetch();

// Calculating Number of Activated Accounts
$q = "SELECT COUNT(*) FROM users WHERE activated = '1'";
$db->DoQuery($q);
$activated_accounts = $db->fetch();

// Calculating Opening Day
$open = "SELECT value FROM metadata WHERE id = '1'";
$db->DoQuery($open);
$openhr = $db->fetch();
?>

<header>
	<ul>
		<li><a href="index.php" class="active">Dashboard</a></li>
		<li><a href="appointments.php">Appointments</a></li>
		<li><a href="calendar.php">Calendar</a></li>
		<li><a href="customers.php">Customers</a></li>
		<li><a href="settings.php">Settings</a></li>
	</ul>
</header>

<div>
asd
<?php
echo "Number of Registered Accounts: " . $registered_accounts[0] . "<br>";
echo "Number of Bookings This Month: " . $monthly_bookings[0] . "<br>";
echo "Estimated Income This Month: "."&pound;" . $monthly_revenue[0] . "<br>";
echo "Number of Activated Accounts: " . $activated_accounts[0] . "<br>";
echo "Number of Bookings for Today: " . $daily_bookings[0] . "<br>";
echo "<pre>";
echo $openhr[0];
echo "</pre>";
?>
</div>