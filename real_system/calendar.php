<?php
$require_user = true;
$menutype = "user_dashboard";
include_once('includes/core.php'); 
include('classes/calendar.php');
$calendar = new booking_diary($link);
if (isset($_GET['month'])) $month = $_GET['month']; else $month = date("m");
if (isset($_GET['year'])) $year = $_GET['year']; else $year = date("Y");
if (isset($_GET['day'])) $day = $_GET['day']; else $day = 0;
$selected_date = mktime(0, 0, 0, $month, 01, $year); // Make a timestamp based on the GET values
$first_day = date("N", $selected_date) - 1; // Gives numeric representation of the day of the week 1 (for Monday) through 7 (for Sunday)
$back = strtotime("-1 month", $selected_date);
$forward = strtotime("+1 month", $selected_date);
include('includes/header.php');
?>

<?php       
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $calendar->after_post($month, $day, $year);  
}   
// Call calendar function
$calendar->make_calendar($selected_date, $first_day, $back, $forward, $day, $month, $year);
include('includes/footer.php');
?>
