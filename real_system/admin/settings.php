<?php 
$title = "Settings"; 
$menutype = "admin_dashboard";
$require_admin = true;
include_once("../includes/core.php");
if (isset($_POST['service_value']) && isset($_POST['service_id'])){
	$value = $_POST['service_value'];
	$id = $_POST['service_id'];
	// echo "<pre>";
	// 	print_r($id);
	// 	echo "<br>";
	// print_r($value);
	// echo "</pre>";

	if ($id == 1 OR $id == 2){
		if (strlen($value) <> 5){
			array_push($errors, "Please enter a correctly formatted time. (HH:MM)");
		} else {
			if (!preg_match('/(2[0-3]|[01][0-9]):[0-5][0-9]/', $value)){
				array_push($errors, "This is an invalid time.");
			}
		}
	}
	if ($id == 3){
		if (strlen($value) <> 2){
			array_push($errors, "The booking frequency is either too short or too long. Try again!");
		} else {
			if (!preg_match("/^[0-9]+$/", $value)){
				array_push($errors, "This is an invalid interval.");
			}
		}
	}
	if ($id == 5){
		if (strlen($value) > 50){
			array_push($errors, "The business name is too long.");
		}
		if (strlen($value) <= 1){
			array_push($errors, "The business name is too short.");
		}
	}
	if ($id == 6){
		if (strlen($value) > 50){
			array_push($errors, "The slogan is too long.");
		}
	}

	if (empty($errors)){
		$query = "UPDATE metadata SET value = '$value' WHERE id = '$id'";
		$db->DoQuery($query);
		array_push($update, 'Your information has been updated into the database.');
	}
} 
include($directory . '/includes/header.php');
$query = "SELECT * FROM metadata";
$db->DoQuery($query);
$num = $db->fetchAll();
//$roww = $db->RowCount($query);

?>
<h1>Settings</h1>

<?php

echo "<table style='width:100%'>";
echo "<tr>
		<th>Option</th>
		<th>Value</th>
		<th>Description</th>
	 </tr>";
foreach ($num as $row) {
	echo '<form action="" method="post">';
	echo '<tr>';
    echo '<td>'.$row['rule'].'</td>';
    echo "<td><input id='forms' name='service_value' value='".$row['value']."'></td>";
    echo '<td>'.$row['description'].'</td>';
    echo '<td><button value="'.$row['id'].'" name="service_id">Update</button></td>';
	echo '</tr>';
	echo '</form>';
	}
?>
</form>

</table>

