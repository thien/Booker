<?php 
$title = "Dashboard";
$menutype = "admin_dashboard";
$require_admin = true;
include_once("../includes/core.php");
include($directory . "/functions/encryption.php");
include($directory . '/includes/header.php');

//Calculating Number of Bookings Monthly
$startmonth = date("Y-m") . "-01";
$endmonth = date("Y-m") . "-31";
$r = "SELECT COUNT(*) FROM booking WHERE date >='$startmonth' AND date <='$endmonth'";
$db->DoQuery($r);
$monthly_bookings = $db->fetch();

//Calculating Number of Bookings Daily
$today = date("Y-m-d");
$a = "SELECT COUNT(*) FROM booking WHERE date ='$today'";
$db->DoQuery($a);
$daily_bookings = $db->fetch();

//Calculating Revenue from monthly bookings
$startmonth = date("Y-m") . "-01";
$endmonth = date("Y-m") . "-31";
$l = "SELECT sum(service.price) FROM booking INNER JOIN service ON booking.service_id=service.id WHERE date >='$startmonth' AND date <='$endmonth'";
$db->DoQuery($l);
$monthly_revenue = $db->fetch();

// Calculating Number of Accounts
$q = "SELECT COUNT(*) FROM users";
$db->DoQuery($q);
$registered_accounts = $db->fetch();

// Calculating Number of Activated Accounts
$q = "SELECT COUNT(*) FROM users WHERE activated = '1'";
$db->DoQuery($q);
$activated_accounts = $db->fetch();

// Calculating Opening Day
$open = "SELECT value FROM metadata WHERE id = '1'";
$db->DoQuery($open);
$openhr = $db->fetch();
?>

<div>

<h1>Statistics</h1>
<?php
echo "Number of Registered Accounts: " . $registered_accounts[0] . "<br>";
echo "Number of Online Bookings This Month: " . $monthly_bookings[0] . "<br>";
echo "Estimated Income This Month from Online Bookings: "."&pound;" . $monthly_revenue[0] . "<br>";
echo "Number of Activated Accounts: " . $activated_accounts[0] . "<br>";
echo "Number of Bookings for Today: " . $daily_bookings[0] . "<br>";
?>
</div>

<script src="/assets/chart.min.js"></script>
<script src="/assets/chart.doughnut.js"></script>
<script src="/assets/chart.line.js"></script>

<div id="left">
	<h3>Service Popularity</h3>
	<div id="canvas-holder">
		<canvas id="service_popularity"/></div>
</div><div id="right">
<h3>Bookings Per Month</h3>
<div id="canvas-holder">
	<canvas id="graph"/></div>
</div>

<?php 

// Pie Chart Statistics

 $query = "SELECT COUNT(*) FROM service";
 $db->DoQuery($query);
 $totalrows = $db->fetch();
 $totalrow =  $totalrows[0] - 1;

 $query =  "SELECT id, type FROM service";
 $db->DoQuery($query);
 $services = $db->fetchAll();

for ($x = 0; $x <= ($totalrows[0]-1); $x++){
	$query = "SELECT COUNT(*) FROM booking WHERE service_id = '".$services[$x]['id']."'";
	$db->DoQuery($query);
	$counter = $db->fetch();
	array_push($services[$x], $counter[0]);
	array_push($services[$x], mb_substr(bin2hex($services[$x]['type']), 0, 6));
}

// Line graph Statistics

function count_instances($os_values, $month){
  $count = 0;
  foreach($os_values as $i)
    if(strpos($i, $month)!== FALSE)
      $count++;
  return $count;
}

$months = array();
$os_values = array();
$query = "SELECT date FROM booking WHERE date > DATE_SUB(now(), INTERVAL 6 MONTH) ORDER BY date ASC";
$db->DoQuery($query);
$total = $db->fetchAll();

foreach ($total as $counts) {
	$x = 0;
	$date = date("Y-m",strtotime($counts[$x]));
	$x++;
	if (!in_array($date, $months)){
		array_push($months, $date); //creation of months array
	}
}

foreach ($total as $t){
	array_push($os_values, $t[0]);
}
?>
<script>
<?php

//Piechart

echo "var piechart = [ ";
for ($x = 0; $x <= ($totalrow); $x++){
 	echo "{ ";
 	echo "value: ".$services[$x][2].", ";
 	echo 'color:"#'.$services[$x][3].'", ';
	echo 'highlight: "#'.dechex(hexdec($services[$x][3])+(pow(2,13))).'", ';
 	echo 'label: "'.$services[$x][1].'" ';
 	if ($x == $totalrow){
 	echo "} ";
 	} else {
 		echo "}, ";
	 	}
	 }
	 echo "]; ";

//Graph

echo "var linechart = { ";
echo "labels : [";
for ($x = 0; $x <= (count($months)-1); $x++){
	if ($x == count($months)-1){
 		echo '"'.date("M",strtotime($months[$x])).'"], ';
 	} else {
 		echo '"'.date("M",strtotime($months[$x])).'",';
 	}
}
echo "datasets : [ { ";
echo 'label: "Bookings Per Month",
	fillColor : "rgba(220,220,220,0.2)",
	strokeColor : "rgba(220,220,220,1)",
	pointColor : "rgba(220,220,220,1)",
	pointStrokeColor : "#fff",
	pointHighlightFill : "#fff",
	pointHighlightStroke : "rgba(220,220,220,1)", ';
	echo "data : [";
for ($x = 0; $x <= (count($months)-1); $x++){
	if ($x == count($months)-1){
 		echo count_instances($os_values, $months[$x]);
 	} else {
 		echo count_instances($os_values, $months[$x]).",";
 	}
}
echo "] } ] }";
?>

window.onload = function(){
	var ctx = document.getElementById("service_popularity").getContext("2d");
	window.myPie = new Chart(ctx).Pie(piechart, {
		responsive : true,
		animateRotate : false
	});
	var ctx2 = document.getElementById("graph").getContext("2d");
	window.myLine = new Chart(ctx2).Line(linechart, {
		responsive: true
	});
};

</script>
