<?php 
$title = 'Manage Appointments';
$menutype = "user_dashboard";
$morethantoday = 1;
include_once("includes/core.php");
$date = date("Y-m-d");
$query = "SELECT booking.id, booking.date, booking.time, booking.comments, service.type, service.price FROM booking INNER JOIN service ON booking.service_id=service.id; WHERE booking.username = :username";
$query_params = array(
    ':username' => $_COOKIE['userdata']['username']
);
if (isset($_GET['option'])){
$option = $_GET['option'];
} else {
$option = 'upcoming';
}
$db->DoQuery($query, $query_params);
$num = $db->fetchAll();
if (isset($_POST['id_delete'])) 
{
          foreach ( $_POST['id_delete'] as $id_d) {
            $query = "DELETE FROM booking WHERE id = :id";
            $query_params = array(
                ':id' => $id_d
            );
            $db->DoQuery($query, $query_params);
            echo("<meta http-equiv='refresh' content='0'>");
        }
}
include 'includes/header.php';
?>


<a href="?option=past">Past</a><a href="?option=upcoming">Upcoming</a>
<a href="?option=all">all</a>
<?php
if (isset($option)){
if ($option == "past"){
echo '<h1>Past Appointments.</h1>';
} elseif ($option == "upcoming"){
echo '<h1>Upcoming Appointments.</h1>';
} elseif ($option == "all"){
echo '<h1>All Appointments</h1>';
}}?>
<form method='post' action='manage_appointments.php'>
<div class="appointments">
<?php 
if (isset($option)){
if ($option == "past"){
	foreach ($num as $row) {
		$dtA = strtotime($row['date'] ." ". $row['time']);
		if ($dtA<time()) {
			echo "<div id='group'>";
				echo "<div class='left'>";
		    		echo '<b>'.date("D, d M Y", strtotime($row['date'])).'</b><br>';
		    		echo date("g:i A", strtotime($row['time'])).'<br>';
		    		echo $row['type']."<br><br>";
		    		echo $row['comments']."<br>";
		  		echo "</div><div class='right'>";
		  	  		echo '&pound;'.$row['price'].'<br>';
		  	echo '</div></div>';
		}
	}
}
elseif($option == "upcoming"){
	foreach ($num as $row) {
		$dtA = strtotime($row['date'] ." ". $row['time']);
		if ($dtA>time()) {
			echo "<div id='group'>";
				echo "<div class='left'>";
			    	echo '<b>'.date("D, d M Y", strtotime($row['date'])).'</b><br>';
		    		echo date("g:i A", strtotime($row['time'])).'<br>';
		    		echo $row['type']."<br><br>";
		    		echo $row['comments']."<br>";
		  		echo "</div><div class='right'>";
		  	  		echo '&pound;'.$row['price'].'<br>';
		  	  		if ($dtA>time()){
		  			echo "<input type='submit' class='buttons' value='Cancel'>";
		  			}
		  	echo '</div></div>';
		}
} 
}
elseif($option == "all"){
	foreach ($num as $row) {
		$dtA = strtotime($row['date'] ." ". $row['time']);
					echo "<div id='group'>";
				echo "<div class='left'>";
			    	echo '<b>'.date("D, d M Y", strtotime($row['date'])).'</b><br>';
		    		echo date("g:i A", strtotime($row['time'])).'<br>';
		    		echo $row['type']."<br><br>";
		    		echo $row['comments']."<br>";
		  		echo "</div><div class='right'>";
		  	  		echo '&pound;'.$row['price'].'<br>';
		  	  		if ($dtA>time()){
		  			echo "<input type='submit' class='buttons' value='Cancel'>";
		  			}
		  	echo '</div></div>';
		 } 
}
}
?>
</div>
 </form>


<div class="appointments">

<?php
//foreach ($num as $row) {
//$dtA = strtotime($row['date'] ." ". $row['time']);
//if ($dtA>time()) {
//echo "<div id='booking'>";
//	echo '<tr>';
//    echo '<td>'.$row['date'].'</td>';
//    echo '<td>'.$row['time'].'</td>';
//    echo '<td>'.$row['type'].'</td>';
//    echo '<td>'.$row['comments'].'</td>';
//    echo '<td>&pound;'.$row['price'].'</td>';
//	echo '</tr></div>'; 
//	}
?>
</div>
    
<br>
<a href="calendar.php"><button class="buttons" value="Make New Reservation">Make New Reservation</button></a>

<?php 
include 'includes/footer.php';
?>
