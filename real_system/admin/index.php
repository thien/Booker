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
asd
<?php
echo "Number of Registered Accounts: " . $registered_accounts[0] . "<br>";
echo "Number of Bookings This Month: " . $monthly_bookings[0] . "<br>";
echo "Estimated Income This Month: "."&pound;" . $monthly_revenue[0] . "<br>";
echo "Number of Activated Accounts: " . $activated_accounts[0] . "<br>";
echo "Number of Bookings for Today: " . $daily_bookings[0] . "<br>";
?>



</div>


<script src="/assets/chart.min.js"></script>
<script src="/assets/chart.doughnut.js"></script>

<h3>Service Popularity</h3>
<div id="canvas-holder">
			<canvas id="service_popularity" width="500" height="500"/>
</div>

<h3>Graph</h3>
<div id="canvas-holder">
			<canvas id="graph" width="500" height="500"/>
</div>



	<script>
		var doughnutData = [
				{
					value: 300,
					color:"#F7464A",
					highlight: "#FF5A5E",
					label: "Red"
				},
				{
					value: 50,
					color: "#46BFBD",
					highlight: "#5AD3D1",
					label: "Green"
				},
				{
					value: 100,
					color: "#FDB45C",
					highlight: "#FFC870",
					label: "Yellow"
				},
				{
					value: 40,
					color: "#949FB1",
					highlight: "#A8B3C5",
					label: "Grey"
				},
				{
					value: 120,
					color: "#4D5360",
					highlight: "#616774",
					label: "Dark Grey"
				}

			];

			var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
		var lineChartData = {
			labels : ["January","February","March","April","May","June","July"],
			datasets : [
				{
					label: "My First dataset",
					fillColor : "rgba(220,220,220,0.2)",
					strokeColor : "rgba(220,220,220,1)",
					pointColor : "rgba(220,220,220,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(220,220,220,1)",
					data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
				},
				{
					label: "My Second dataset",
					fillColor : "rgba(151,187,205,0.2)",
					strokeColor : "rgba(151,187,205,1)",
					pointColor : "rgba(151,187,205,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(151,187,205,1)",
					data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
				}
			]

		}

			window.onload = function(){
				var ctx = document.getElementById("service_popularity").getContext("2d");
				window.myPie = new Chart(ctx).Pie(doughnutData, {
					responsive : true,
					animateRotate : false
				});
				var ctx2 = document.getElementById("graph").getContext("2d");
				window.myLine = new Chart(ctx2).Line(lineChartData, {
					responsive: true
				});
			};





	</script>


		<style>
			#canvas-holder{
				width:30%;
			}
		</style>
