<?php
$title = 'Book Appointment';
$menutype = "user_dashboard";
$require_user = true;
include_once('includes/core.php'); 
include('classes/calendar.php');
$calendar = new booking_diary($link);
if (isset($_GET['month'])) $month = $_GET['month']; else $month = date("m");
if (isset($_GET['year'])) $year = $_GET['year']; else $year = date("Y");
if (isset($_GET['day'])) $day = $_GET['day']; else $day = 0;
$selected_date = $year . "-" . $month . "-" . $day;
$selected_date_timestamp = mktime(0, 0, 0, $month, 01, $year); // Make a timestamp based on the GET values
$first_day = date("N", $selected_date_timestamp) - 1; // Gives numeric representation of the day of the week 1 (for Monday) through 7 (for Sunday)
$back = strtotime("-1 month", $selected_date_timestamp);
$forward = strtotime("+1 month", $selected_date_timestamp);
include('includes/header.php');
$errors = array();
?>

<?php       
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $calendar->after_post($month, $day, $year);  
}   
// Call calendar function

$closed_days_query = "SELECT date FROM closed_days WHERE YEAR(date) = YEAR('$selected_date') AND MONTH(date) = MONTH('$selected_date')";
$db->DoQuery($closed_days_query);
$closed_days = $db->fetchAll();
$closed_days_query = "SELECT value FROM metadata WHERE id = 4";
$db->DoQuery($closed_days_query);
$fullybooked = $db->fetch();
$numberofbookingsonday = "SELECT COUNT(*) FROM booking WHERE YEAR(date) = YEAR('$selected_date') AND MONTH(date) = MONTH('$selected_date') AND DAY(date) = DAY('$selected_date')";
$db->DoQuery($numberofbookingsonday);
$day_count = $db->fetch();


foreach ($closed_days as $item) {  // It's a closed day, set from the database.
    if (strtotime($item['date']) == strtotime($selected_date)){
        array_push($errors, "We would be closed on the date chosen.");
    }
}

if(date('w', strtotime($selected_date)) == 0 AND $day !== 0) {
   array_push($errors, "We don't open on sundays.");
}

if ($day_count[0] >= $fullybooked[0]){
   array_push($errors, "Today is fully booked.");
}

if (empty($errors)) {
$calendar->make_calendar($selected_date_timestamp, $first_day, $back, $forward, $day, $month, $year);
} else {
	echo "<h1>This date is unavailable right now.</h1>";
	foreach ($errors as $error) {
		echo $error . "<br>";
	}
		echo "You can click <a href='calendar.php'>here</a> to go back on the calendar.";
}
echo "</div>";
include('includes/footer.php');
?>
