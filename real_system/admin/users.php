<?php 
$menutype = "admin_dashboard";
$title = "Users";  
$require_admin = true;
include_once("../functions/encryption.php");
include_once("../functions/email.php");
include_once("../includes/core.php");

function list_staff($staff_details = array()){
	echo '<form action="" method="post" autocomplete="off">';
	echo '<div id="group">'; 
	echo '<div id="left">'; 
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
	echo '<div id="right">';
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

if (isset($_GET['usertype'])){
	$usertype = $_GET['usertype'];
	} else {
	$usertype = 'customers';
}
if (isset($_GET['user_id'])){
	$user_id = $_GET['user_id'];
	$query = "SELECT * FROM users WHERE id = '$user_id'";
	$db->DoQuery($query);
	$q = $db->Fetch();
	if (empty($q)){
		array_push($errors, "The userid ".$user_id." doesn't exist.");
	}
}
if ($usertype == 'customers'){

	if(!isset($_GET['char'])){
	$char="A";
	}else{
	$char=$_GET['char'];
	}
	$query = "SELECT * FROM users WHERE surname LIKE '".$char."%' ORDER BY username ASC";
	$count_rows = "SELECT count(*) FROM users WHERE surname LIKE '".$char."%'";
	$db->DoQuery($count_rows);
	$count = $db->fetch();

	// echo $count[0];
	//Add following after it
	$per_page =10;//define how many games for a page
	$pages = ceil($count[0]/$per_page);

	if(!isset($_GET['page'])){
	$page="1";
	}else{
	$page=$_GET['page'];
	}
	$start = ($page - 1) * $per_page;
	$query = $query . " LIMIT $start, $per_page";
	$db->DoQuery($query);
	$num = $db->fetchAll();

}
if ($usertype == 'staff'){
	$query = "SELECT * FROM staff ORDER BY id ASC";
	$db->DoQuery($query);
	$num = $db->fetchAll();
}

if (isset($_POST)){

	if (isset($_POST['forename'])){
	$forename = trim($_POST['forename']);
		if (strlen($forename) < 1){
	  	array_push($errors, "Please type in a forename.");
	  	}
	}
	if (isset($_POST['surname'])){
	$surname = trim($_POST['surname']);
		if (strlen($surname) < 1){
	  	array_push($errors, "Please type in a surname.");
	  	}
	}
	if (isset($_POST['email'])){
		$email = trim($_POST['email']);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
	  	array_push($errors, "Please specify a valid email address.");
	  	}
	}

	if (count($errors) == 0) {
		if (isset($_POST['register'])){

			$query = "SELECT pin FROM staff";
			$db->DoQuery($query);
			$used_pins = $db->fetch();
			if (!empty($used_pins)){
			$newpins = generate_pin($used_pins);
			} else {
			$newpins = generate_pin();
			}
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

			if ($usertype == 'customers'){
			$id = $_POST['id_ban'];
			$query = "UPDATE users SET banned = true WHERE id = $id";
			$db->DoQuery($query);
			array_push($update, $q['forename']." is now banned.");
			}
			if ($usertype == 'staff'){
			$id = $_POST['id_ban'];
			$query = "UPDATE staff SET banned = true WHERE id = $id";
			$db->DoQuery($query);
			array_push($update, $_POST['forename']." is now banned from the Staff List.");
			}
		}

		if (isset($_POST['id_unban'])){
			if ($usertype == 'customers'){
			$id = $_POST['id_unban'];
			$query = "UPDATE users SET banned = false WHERE id = $id";
			$db->DoQuery($query);
			array_push($update, $q['forename']." is now unbanned.");
			}
			if ($usertype == 'staff'){
			$id = $_POST['id_unban'];
			$query = "UPDATE staff SET banned = false WHERE id = $id";
			$db->DoQuery($query);
			array_push($update, $_POST['forename']." is now unbanned from the Staff List.");
			}
		}

		if (isset($_POST['new_pin_request'])){

			$id = $_POST['new_pin_request'];

			$query = "SELECT pin FROM staff";
			$db->DoQuery($query);
			$used_pins = $db->fetch();
			if (!empty($used_pins)){
			$newpins = generate_pin($used_pins);
			} else {
			$newpins = generate_pin();
			}

			include_once("../functions/email.php");

			$email_params = array(
				':pin' => $newpins['pin']
			);
			$query_params = array(
				':pin' => $newpins['pin_hash'],
				':id' => $id
			);
			email($staff_details['s_email'], "Staff", $staff_details['s_forename'], "new_pin", $email_params);

			$query = "UPDATE staff SET pin = :pin WHERE id = :id";
			$db->DoQuery($query, $query_params);

			array_push($update, "A new pin has been set to ".$forename.".");
		}
	}
}

include($directory . '/includes/header.php');
?>

<select id="navigator" autofocus onchange="location = this.options[this.selectedIndex].value;">
 <option value="?usertype=customers" <?php if($usertype == "customers") {echo 'selected="selected"';}?>>Customers</option>
 <option value="?usertype=staff" <?php if($usertype == "staff") {echo 'selected="selected"';}?>>Staff</option>
</select>


<?php 

if ($usertype =='customers'){

	if (!empty($q)){
		$query = "SELECT COUNT(*) FROM booking WHERE user_id = '$user_id'";
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
				if ($q['banned'] == 0){
					echo '<button value="'.$q['id'].'" name="id_ban">Ban</button>';
				} else {
					echo '<button value="'.$q['id'].'" name="id_unban">Unban</button>';
				}
			echo '</div>';
		echo '</div>';
		echo '</form>';
	
	} else {
		//list alphabet
		echo '<ul id="pagination">';
		foreach (range('A', 'Z') as $chara) {
			if ($char == $chara){
				echo '<li id="active"><a href="users.php?char='.$chara.'">'.$chara."</a></li>\n";
			} else {
				echo '<li><a href="users.php?char='.$chara.'">'.$chara."</a></li>\n";
			}
		}
		 echo '</ul>';


		echo '<ul id="pagination">';
        //Show page links
        for ($i = 1; $i <= $pages; $i++){
               if ($page == $i){
			       echo '<li id="active"><a href="users.php?char='.$char.'&page='.$i.'">'.$i.'</a></li>'; 
			    } else {
			        echo '<li><a href="users.php?char='.$char.'&page='.$i.'">'.$i.'</a></li>'; 
			    }    
          }
      echo '</ul>';

     	if (!count($num) < 1){
			foreach ($num as $row) {
				echo '<p><a href="users.php?usertype=customers&user_id='.$row['id'].'">';
				echo $row['id']." - ".$row['forename']." ".$row['surname']." (".$row['username'].")".'</a></p>';
			}
		} else {
			echo '<h1>There\'s no customers here..</h1>';
			echo 'Try the other letters?';
		}
	}
 } 
elseif ($usertype == 'staff') {

	echo "<h1>Staff</h1>";
	 array_shift($num);
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
