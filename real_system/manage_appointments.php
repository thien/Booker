
<?php 
$title = 'Manage Appointments';
$menutype = "user_dashboard";
include_once("includes/core.php");

$date = date("Y-m-d");
$query = "SELECT date, time, comments FROM booking WHERE username = :username";
$query_params = array(
    ':username' => $_COOKIE['userdata']['username']
);
$db->DoQuery($query, $query_params);
$num = $db->fetchAll(PDO::FETCH_NUM);

if(isset($_POST['delete'])){
     $delete_id = $_POST['checkbox'];
     $id = count($delete_id);
     if (count($id) > 0) {
         foreach ($delete_id as $id_d) {
            $query = "DELETE FROM `bookings` WHERE id='$id_d'";
            $delete = $db->DoQuery($query);
        }
    }
    if($delete) {
        echo $id." Records deleted Successfully.";
    }
}
include 'includes/header.php';

?>


<h1>Your Appointments.</h1>




<?php 


echo "<table style='width:100%'>";
echo "<tr>
		<td>Date</td>
		<td>Time</td>
		<td>Comments</td>
	 </tr>";
foreach ($num as $row) {
	echo '<tr>';
	echo '<td>'.$row[0].'</td>';
    echo '<td>'.$row[1].'</td>';
    echo '<td>'.$row[2].'</td>';
    echo '<td><input name="checkbox[]" type="checkbox" id="checkbox[]" value="'.$row[0].'"></td>';
	echo '</tr>';
}

?><?php
echo "</table>";
?>


<tr><td><button type="submit" name="delete" value="Delete" id="delete"></button></td></tr>

<?php 
include 'includes/footer.php';
?>




