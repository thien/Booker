<?php
$title = "Appointments";
$menutype = "admin_dashboard";
include_once("../includes/core.php");
include("../functions/list_appointment_results.php");
$date = date("Y-m-d");
$query = "SELECT booking.id, booking.date, users.forename, users.surname, booking.time, booking.comments, booking.confirmedbystaff, booking.staff_id, service.type, service.price 
FROM booking INNER JOIN users ON booking.username = users.username INNER JOIN service ON booking.service_id = service.id";
$db->DoQuery($query);
$num = $db->fetchAll();



include '../includes/header.php';
?>



<h1>Appointments</h1>

<?php

$parameters = array(
'show' => "all"
);
print_r($parameters);
list_appointments($num, $parameters);
?>





<?php 
include '../includes/footer.php';
?>


<script>
$( "#accordion" ).accordion();
//$("#accordion li div").click(function(){
//    $(this).next().slideToggle(300);
//});
$(".pinToggles").click(function(event){
    event.stopPropagation();
});
</script>
