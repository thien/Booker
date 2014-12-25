<?php 
$menutype = "admin_dashboard";
$title = "Users";  
include_once("../functions/encryption.php");
include_once("../functions/email.php");
include_once("../includes/core.php");

function list_staff($staff_details = array()){



	// echo "<pre>";
	// print_r($staff_details);
	// echo "</pre>";

	echo '<form action="" method="post" autocomplete="off">';
	echo '<div id="details">'; 
	echo '<div class="left">'; 
	// echo $row['s_forename'] ." ". $row['s_surname']; 
	echo '<label>Forename:</label><br>';
	if (isset($staff_details['s_forename'])){
		echo '<input type="text" name="forename" placeholder="Forename" value="'.$staff_details['s_forename'].'"/>';
	} else {
	echo '<input type="text" name="forename" placeholder="Forename"/>';
	}
	echo '<label>Surname:</label><br>';
	if (isset($staff_details['s_surname'])){
		echo '<input type="text" name="surname" placeholder="Surname" value="'.$staff_details['s_surname'].'"/>';
	} else {
	echo '<input type="text" name="surname" placeholder="Surname"/>';
	}
	echo '<label>Email:</label><br>';
	if (isset($staff_details['s_email'])){
		echo '<input type="text" name="email" placeholder="email" value='.$staff_details['s_email'].'>';
	} else {
	echo '<input type="text" name="email" placeholder="email">';
	}
	echo '</div>';
	echo '<div class="right">';
	if (isset($staff_details[0])){
		echo '<button value="'.$staff_details[0].'" name="id_update">Update</button>';
		if ($staff_details['banned'] == 0){
			echo '<button value="'.$staff_details[0].'" name="id_ban">Ban</button>';
		} else {
			echo '<button value="'.$staff_details[0].'" name="id_unban">Unban</button>';
		}
		echo '<button value="'.$staff_details[0].'" name="new_pin_request">Generate New PIN</button>';
	} else {
	echo '<button type="submit" value="true" name="register">Register</button>';
	}
	echo '</div>';
	echo '</form>';
	echo '</div>';
}

function generate_pin($used_pins = array()){
	$new_pin = rand(10000,99999);
	$new_pin_hash = encrypt($new_pin);
	while (in_array($new_pin_hash, $used_pins)){

		//current pin is in use, trying again with newly generated pin.
		$new_pin = rand(10000,99999);
		//encrypt new pin
		$new_hash = encrypt($new_pin);
		//assign new pin hash to check in array. if fails loop will iterate
		$new_pin_hash = $new_hash;
	}
	return array(
		'pin' => $new_pin,
		'pin_hash' => $new_pin_hash
	);
}

if (isset($_POST['register'])){
	$forename = $_POST['forename'];
	$surname = $_POST['surname'];
	$email = $_POST['email'];

	$query = "SELECT pin FROM staff";
	$db->DoQuery($query);
	$used_pins = $db->fetch();
	$newpins = generate_pin($used_pins);
	// echo "your new pin is ";
	// print_r($newpins);
	// echo $newpins['pin'] . "<br>";
	// echo $newpins['pin_hash'];


	$query_params = array(
		':pin' => $newpins['pin']
	);
	email($email, "Staff", $forename, "new_staff", $query_params);

	$query = "INSERT INTO staff (s_forename, s_surname, s_email, pin) VALUES (:forename, :surname, :email, :pin)";
	$query_params = array(
		':forename' => $forename,
		':surname' => $surname,
		':email' => $email,
		':pin' => $newpins['pin_hash']
	);
	// print_r($query_params);
	$db->DoQuery($query, $query_params);
	array_push($update, "$forename has been included into the database. A PIN is sent to his email address at $email.");
}

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

if (isset($_POST['id_ban'])){
	$id = $_POST['id_ban'];
	$query = "UPDATE staff SET banned = true WHERE id = $id";
	$db->DoQuery($query);
	array_push($update, $_POST['forename']." is now banned from the Staff List.");
}

if (isset($_POST['id_unban'])){
	$id = $_POST['id_unban'];
	$query = "UPDATE staff SET banned = false WHERE id = $id";
	$db->DoQuery($query);
	array_push($update, $_POST['forename']." is now unbanned from the Staff List.");
}

if (isset($_POST['new_pin_request'])){

	$forename = $_POST['forename'];
	$surname = $_POST['surname'];
	$surname = $_POST['email'];
	$id = $_POST['new_pin_request'];

	$new_pin = rand(10000,99999);

	$new_pin_hash = encrypt($new_pin);

	$query = "SELECT pin FROM staff";
	$db->DoQuery($query);
	$used_pins = $db->fetch();
	while (in_array($new_pin_hash, $used_pins)){

		//current pin is in use, trying again with newly generated pin.
		$new_pin = rand(10000,99999);
		//encrypt new pin
		$new_hash = encrypt($new_pin);
		//assign new pin hash to check in array. if fails loop will iterate
		$new_pin_hash = $new_hash;
	}

	//New pin is available

	include_once("../functions/email.php");

	$query = "SELECT * FROM staff WHERE id = $id";
	$db->DoQuery($query);
	$staff_details = $db->fetch();

	$query_params = array(
		':pin' => $new_pin_hash,
		':id' => $id
	);
	email($staff_details['s_email'], "Staff", $staff_details['s_forename'], "new_pin", $query_params);

	$query = "UPDATE staff SET pin = :pin WHERE id = :id";
	$db->DoQuery($query, $query_params);

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

	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";

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
 } 
elseif ($usertype == 'staff') {

	echo "<h1>Staff</h1>";
	foreach ($num as $row) {
		


		list_staff($row);
	}
	echo '<h2>Register New Staff</h2>';
		list_staff();
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
