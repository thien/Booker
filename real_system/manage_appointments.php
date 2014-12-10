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
<!--<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script><ul id="accordion">
    <li><div>
    		Attractions<input type="checkbox" id="greenCheck" name="pinSet" value="Green"  class="pinToggles">
        </div>
        <ul>
            <li><a href="#">Outdoor Waterparks</a></li>
            <li><a href="#">Indoor Waterparks</a></li>
            <li><a href="#">Go-kart Track</a></li>
        </ul>
    </li>
    <li><div>
    		<input type="checkbox" id="redCheck" name="pinSet" value="Red" class="pinToggles" onclick="pinSetCheck(redSet)">Dining & Shopping
        </div>
        <ul>
            <li><a href="#">Restaurant 1</a></li>
            <li><a href="#">Restaurant 2</a></li>
            <li><a href="#">Restaurant 3</a></li>
        </ul>
    </li>
</ul> 
<script>
$( "#accordion" ).accordion();
//$("#accordion li div").click(function(){
//    $(this).next().slideToggle(300);
//});
$(".pinToggles").click(function(event){
    event.stopPropagation();
});
</script>-->








<h1>Recent Appointments.</h1>


<ul id="accordion">
    
<?php 
foreach ($num as $row) {
$dtA = strtotime($row['date'] ." ". $row['time']);
if ($dtA<time()) {
	echo '<li><div>';
	echo $row['date'].$row['time'].$row['type'];

  	echo '</div> <ul>';
    
    echo $row['date'];
    echo $row['time'];
    echo $row['type'];
    echo $row['comments'];
    echo '&pound;'.$row['price'];
    
    
		echo '</ul></li>';

}}
echo "</ul>";

?>

<h1>Your Upcoming Appointments.</h1>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

<!--

<ul id="accordion">
    <li><div>
    		Attractions<input type="checkbox" id="greenCheck" name="pinSet" value="Green"  class="pinToggles">
        </div>
        <ul>
            <li><a href="#">Outdoor Waterparks</a></li>
            <li><a href="#">Indoor Waterparks</a></li>
            <li><a href="#">Go-kart Track</a></li>
        </ul>
    </li>
    <li><div>
    		<input type="checkbox" id="redCheck" name="pinSet" value="Red" class="pinToggles" onclick="pinSetCheck(redSet)">Dining & Shopping
        </div>
        <ul>
            <li><a href="#">Restaurant 1</a></li>
            <li><a href="#">Restaurant 2</a></li>
            <li><a href="#">Restaurant 3</a></li>
        </ul>
    </li>
</ul> 

-->

<?php if(!empty($num)) { ?>
<form method='post' action='manage_appointments.php'>


<table style='width:100%'>
<tr>
	<td>Date</td>
	<td>Time</td>
    <td>Service</td>
	<td>Comments</td>
    <td>Price</td>
</tr>

<?php foreach ($num as $row) {
$dtA = strtotime($row['date'] ." ". $row['time']);
if ($dtA>time()) {
	echo '<tr>';
    echo '<td>'.$row['date'].'</td>';
    echo '<td>'.$row['time'].'</td>';
    echo '<td>'.$row['type'].'</td>';
    echo '<td>'.$row['comments'].'</td>';
    echo '<td>&pound;'.$row['price'].'</td>';
	echo '</tr>'; 
	}
}
echo "</table>";
?>

<ul id="accordion">
    
<?php 
foreach ($num as $row) {
$dtA = strtotime($row['date'] ." ". $row['time']);
if ($dtA>time()) {
	++$morethantoday;
	echo '<li><div>';
	echo $row['date'].$row['time'].$row['type'];
	echo '<input class="pinToggles" type="checkbox" name="id_delete[]" value="'.$row['id'].'">';
  	echo '</div> <ul>';
    
    echo $row['date'];
    echo $row['time'];
    echo $row['type'];
    echo $row['comments'];
    echo '&pound;'.$row['price'];
    
    
		echo '</ul></li>';

}}
echo "</ul>";

?><br>
<input type='submit' class='buttons' value="Delete Selected"> </form>
<a href="calendar.php"><button class="buttons" value="Make New Reservation">Make New Reservation</button></a>
<?php }

if ($morethantoday == 1) {
  echo 'nigger';
      echo $morethantoday;
}

?>
<?php 
include 'includes/footer.php';
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
