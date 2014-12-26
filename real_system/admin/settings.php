<?php 
$require_admin = true;
include_once("../includes/core.php");
if (isset($_POST['service_value']) && isset($_POST['service_id'])){
	$value = $_POST['service_value'];
	$id = $_POST['service_id'];
	$query = "UPDATE metadata SET value = '$value' WHERE id = '$id'";
	$db->DoQuery($query);
	array_push($update, 'Your information has been updated into the database.');
}
	$menutype = "admin_dashboard";
  $title = "Settings";  
  $errors = array();


include($directory . '/includes/header.php');
$query = "SELECT * FROM metadata";
$db->DoQuery($query);
$num = $db->fetchAll(PDO::FETCH_NUM);
//$roww = $db->RowCount($query);

?>
<h1>Settings</h1>

<?php

    display_errors($errors);
    display_updates($update);

echo "<table id='mytable' style='width:100%'>";
echo "<tr>
		<th>Option</th>
		<th>Value</th>
		<th>Description</th>
	 </tr>";
foreach ($num as $row) {
	echo '<form action="settings.php" method="post">';
	echo '<tr>';
    echo '<td>'.$row['rule'].'</td>';
    echo '<td><input id="forms" name="service_value" placeholder="value" value='.$row['value'].'></td>';
    echo '<td>'.$row['description'].'</td>';
    echo '<td><button value="'.$row['id'].'" name="service_id">Update</button></td>';
	echo '</tr>';
	echo '</form>';
	}
?>
</form>
<!--<form action="services.php" method="post" autocomplete="off">
<tr>
<td><input type="text" name="service_name" placeholder="Name"/></td>
<td><input type="number" name="service_price" size="4" placeholder="Price"/></td>
<td><input type="text" name="service_description" placeholder="Description"/></td>
<td><button>add</button></td>
</tr>
</form>-->
</table>

