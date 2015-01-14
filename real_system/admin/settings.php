<?php 
$title = "Settings"; 
$menutype = "admin_dashboard";
$require_admin = true;
include_once("../includes/core.php");
if (isset($_POST['service_value']) && isset($_POST['service_id'])){
	$value = $_POST['service_value'];
	$id = $_POST['service_id'];
	$query = "UPDATE metadata SET value = '$value' WHERE id = '$id'";
	$db->DoQuery($query);
	array_push($update, 'Your information has been updated into the database.');
} 
  $errors = array();


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

