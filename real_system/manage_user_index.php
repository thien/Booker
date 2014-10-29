<?php 
include_once("includes/core.php");
include("functions/encryption.php");


$date = date("Y-m-d");
$query = "SELECT * FROM client WHERE username = :username";
$query_params = array(
    ':username' => $_COOKIE['userdata']['username']
);
$db->DoQuery($query, $query_params);
$num = $db->fetchCustomers();


include 'includes/header.php';
?>

<header>
  <ul>
    <li><a href="manage_appointments.php">Make New Appointment</a></li>
    <li><a href="manage_appointments.php" class="active">Manage</a></li>
    <li><a href="manage_user.php">Settings</a></li>
  </ul>
</header>


<h1>Your Information.</h1>






</div>
<?php 
include 'includes/footer.php';
?>




