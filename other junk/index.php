<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include('php/connect.php'); 
include('classes/class_calendar.php');

$calendar = new booking_diary($link);

if(isset($_GET['month'])) $month = $_GET['month']; else $month = date("m");
if(isset($_GET['year'])) $year = $_GET['year']; else $year = date("Y");
if(isset($_GET['day'])) $day = $_GET['day']; else $day = 0;

// Unix Timestamp of the date a user has clicked on
$selected_date = mktime(0, 0, 0, $month, 01, $year); 

// Unix Timestamp of the previous month which is used to give the back arrow the correct month and year 
$back = strtotime("-1 month", $selected_date); 

// Unix Timestamp of the next month which is used to give the forward arrow the correct month and year 
$forward = strtotime("+1 month", $selected_date);

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Calendar</title>
<link href="style.css" rel="stylesheet" type="text/css">



</head>
<body>
<br><br>
	Lorem ipsum dolor <a href="http://google.com">sit</a> amet, <a href="http://google.com">consectetur</a> adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.



</body>
</html>
