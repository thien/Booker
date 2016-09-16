<?php 
$title = 'Manage Appointments';
$menutype = "user_dashboard";
$require_user = true;
include_once("includes/core.php");
$date = date("Y-m-d");
$query = "SELECT booking.id, booking.date, booking.time, booking.comments,
 service.type, service.price FROM booking 
 INNER JOIN service ON booking.service_id=service.id
 WHERE booking.user_id = :user_id
 ORDER BY date ASC ";
$query_params = array(
    ':user_id' => $_COOKIE['userdata']['user_id']
);
if (isset($_GET['option'])){
$option = $_GET['option'];
} else {
$option = 'upcoming';
}
$db->DoQuery($query, $query_params);
$results = $db->fetchAll();
if (isset($_POST['id_delete'])) {
    $query = "DELETE FROM booking WHERE id = :id";
    $query_params = array(':id' => $_POST['id_delete']);
    $db->DoQuery($query, $query_params);
    array_push($update, "Your appointment for is now cancelled.");
}
include 'includes/header.php';
?>

<select id="navigator" autofocus onchange="location = this.options[this.selectedIndex].value;">
 <option value="?option=upcoming" <?php if($option == "upcoming") {echo 'selected="selected"';}?>>Upcoming</option>
 <option value="?option=past" <?php if($option == "past") {echo 'selected="selected"';}?>>Past</option>
 <option value="?option=all" <?php if($option == "all") {echo 'selected="selected"';}?>>All</option>
</select>

<?php
if (isset($option)){
if ($option == "past"){
echo '<h1>Past Appointments.</h1>';
} elseif ($option == "upcoming"){
echo '<h1>Upcoming Appointments.</h1>';
} elseif ($option == "all"){
echo '<h1>All Appointments</h1>';
}}?>
<form method='post' action=''>
<div class="appointments">
<?php 
if (isset($option)){
if ($option == "past"){
	foreach ($results as $row) {
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
	foreach ($results as $row) {
		$dtA = strtotime($row['date'] ." ". $row['time']);
		if ($dtA>time()) {
			echo "<div id='group'>";
				echo "<div class='left'>";
			    	echo '<b>'.date("D, d M Y", strtotime($row['date'])).'</b><br>';
		    		echo date("g:i A", strtotime($row['time'])).'<br>';
		    		echo $row['type']."<br><br>";
		    		if (strlen($row['comments']) >= 1){
		    		echo "<h2>Your Comments</h2>";
		    		echo $row['comments']."<br>";
		    		}
		  		echo "</div><div class='right'>";
		  	  		echo '&pound;'.$row['price'].'<br>';
		  	  		if ($dtA>time()){
		  			echo "<button type='submit' class='buttons' name='id_delete' value='".$row['id']."'>Cancel</button>";
		  			}
		  	echo '</div></div>';
		}
} 
}
elseif($option == "all"){
	foreach ($results as $row) {
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
		  			echo "<button type='submit' class='buttons' name='id_delete' value='".$row['id']."'>Cancel</button>";
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
//foreach ($results as $row) {
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
