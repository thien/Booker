<?php
require( "../classes/database.php");
$db = new database();
$db->initiate();

setcookie('staff[id]', $_POST['id'], $staff_expiry, '', '', '', TRUE);

if (isset($_POST['username'])) {
$value = $_POST['username'];
};

$query = "SELECT booking.id, booking.date, users.forename, users.surname,
  booking.time, booking.comments, booking.confirmedbystaff, booking.staff_id, 
  staff.s_forename, staff.s_surname, service.type, service.price 
 FROM booking 
 INNER JOIN users ON booking.username = users.username
 INNER JOIN staff ON booking.staff_id = staff.id
 INNER JOIN service ON booking.service_id = service.id 
WHERE booking.date = CURDATE() AND users.forename like :user 
OR booking.date = CURDATE() AND users.surname like :user
ORDER BY booking.time ASC";
$query_params = array(
	':user' => $value
);
$db->DoQuery($query, $query_params);
$num = $db->fetchAll();

// echo "<pre>";
// print_r($num);
// echo "</pre>";
include("../functions/list_appointment_results.php");
list_appointments($num);
?>