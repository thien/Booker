<?php
require( "../classes/database.php");
$db = new database();
$db->initiate();

if (isset($_POST['username'])) {
$value = $_POST['username'];
};

$date = date("Y-m-d");

$query = "SELECT booking.id, booking.date, users.forename, users.surname, booking.time, booking.comments, booking.confirmedbystaff, booking.staff_id, service.type, service.price 
FROM booking 
INNER JOIN users ON booking.username = users.username
INNER JOIN service ON booking.service_id = service.id
WHERE booking.date = :date AND users.forename like :user OR users.surname like :user
ORDER BY booking.time ASC";
$query_params = array(
	':date' => $date,
	':user' => $value
);
$db->DoQuery($query, $query_params);
$num = $db->fetchAll();

include("../functions/list_appointment_results.php");
list_appointments($num);
?>