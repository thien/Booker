<?php 
$menutype = "admin_dashboard";
$title = "Users";  
include_once("../includes/core.php");

if (isset($_POST['id_update'])){
	$forename = $_POST['forename'];
	$surname = $_POST['surname'];
	$id = $_POST['id_update'];
	$query = "UPDATE staff SET s_forename = :forename, s_surname = :surname WHERE id = :id";
	$query_params = array(
		':forename' => $forename,
		':surname' => $surname,
		':id' => $id
	);
	// print_r($query_params);
	$db->DoQuery($query, $query_params);
	array_push($update, "Staff information has been updated.");
}



if (isset($_POST['new_pin_request'])){

	$forename = $_POST['forename'];
	$surname = $_POST['surname'];
	$surname = $_POST['email'];
	$id = $_POST['new_pin_request'];

	$new_pin = '12345';
	$query = "SELECT pin FROM staff";
	$db->DoQuery($query);
	$used_pins = $db->fetch();
	// echo $pin."<br>";
	while (in_array($new_pin, $used_pins)){
		echo $new_pin .' is in use . <br>';
		$new_pin = rand(10000,99999);	// encrypt($new_pin);
	}

	echo $new_pin;
	// email($email, $username, $forename, "new_pin");

	$query = "UPDATE staff SET pin = :pin WHERE id = :id";
	$query_params = array(
		':pin' => $new_pin,
		':id' => $id
	);
	$db->DoQuery($query, $query_params);
	// if (!empty($check_if_available)){
	// echo $check_if_available[0] ."is found, doing again.";

	// } else {
	// 	echo "pin is not found";
	// }


	// while ($check_if_available) {
	// 	$new_pin = rand(10000,99999);
	// 	// encrypt($new_pin);
	// 	$query = "SELECT pin FROM staff WHERE pin = $new_pin";
	// 	$check_if_available = $db->DoQuery($query);
	// }

	// $id = $_POST['new_pin'];
	// $query = "UPDATE staff SET pin = :pin WHERE id = :id";
	// $query_params = array(
	// 	':pin' => $forename,
	// 	':id' => $id
	// );
	// // print_r($query_params);
	// $db->DoQuery($query, $query_params);
	array_push($update, "A new pin has been set to ".$forename.".");
}


if (isset($_GET['usertype'])){
$usertype = $_GET['usertype'];
} else {
$usertype = 'customers';
}
if (isset($_GET['username'])){
$username = $_GET['username'];
}
if (isset($username)){
	$query = "SELECT * FROM users WHERE username = '$username'";
	$db->DoQuery($query);
	$q = $db->Fetch();
	if (empty($q)){
		array_push($errors, "The username ".$username." doesn't exist.");
	}
}

if ($usertype == 'customers'){
	$query = "SELECT * FROM users ORDER BY username ASC";
	$db->DoQuery($query);
	$num = $db->fetchAll();
}
if ($usertype == 'staff'){
	$query = "SELECT * FROM staff";
	$db->DoQuery($query);
	$num = $db->fetchAll();
}



include($directory . '/includes/header.php');

display_errors($errors);
display_updates($update);
?>

<a href="?usertype=customers">Customers</a>
<a href="?usertype=staff">Staff</a>


<?php 


		echo "<pre>";
		print_r($_POST);
		echo "</pre>";

if ($usertype =='customers'){

	if (!empty($q)){
		$query = "SELECT COUNT(*) FROM booking WHERE username = '$username'";
		$db->DoQuery($query);
		$number_of_bookings = $db->Fetch();

		echo "<form method='post' action=''>";
		echo '<div id="details">';
			echo '<div class="left">';
				echo '<h2>'.$q['username'].'</h2><br>';
				echo '<b>Name</b>  '.$q['forename'].' '.$q['surname'].'<br>';
				echo '<b>Email</b>  '.$q['email'].'<br>';
				echo '<b>Phone No.</b>  '.$q['phoneno'].'<br>';

				echo '<h3>Statistics</h3>';
				echo 'Has booked a total of '.$number_of_bookings[0]." appointments.";
			echo '</div>';
			echo '<div class="right">';
				echo '<button name="ban_id" value="'.$q['id'].'">Ban</button>';
			echo '</div>';
		echo '</div>';
		echo '</form>';
	
	} else {
		foreach ($num as $row) {
			echo '<p><a href="users.php?usertype=customers&username='.$row['username'].'">';
			echo $row['id']." - ".$row['forename']." ".$row['surname']." (".$row['username'].")".'</a></p>';
		}
	}
 } elseif ($usertype == 'staff') {

echo "<h1>Staff</h1>";
foreach ($num as $row) {
	echo '<form action="" method="post" autocomplete="off">';
	echo '<div id="details">'; 
	echo '<div class="left">'; 
	// echo $row['s_forename'] ." ". $row['s_surname']; 
	echo '<label>Forename:</label><br>';
	echo '<input type="text" name="forename" placeholder="Forename" value="'.$row['s_forename'].'"/>';
	echo '<label>Surname:</label><br>';
	echo '<input type="text" name="surname" placeholder="Surname" value='.$row['s_surname'].'>';
	echo '<label>Email:</label><br>';
	echo '<input type="text" name="email" placeholder="email" value='.$row['s_email'].'>';
	echo '<label>PIN:</label><br>';
	echo '<input type="text" name="pin" placeholder="PIN" value='.$row['pin'].'>';

	echo '</div>';
	echo '<div class="right">';
	echo '<button value="'.$row[0].'" name="id_update">Update</button>';
	echo '<button value="'.$row[0].'" name="id_delete">Remove</button>';
	echo '<button value="'.$row[0].'" name="new_pin_request">Generate PIN</button>';
	echo '</div>';
	echo '</form>';
	echo '</div>';
}

}

?>

<script>
$('html').bind('keypress', function(e)
{
   if(e.keyCode == 13)
   {
      return false;
   }
});
</script>
