<?php 
$title = "Checkin";
 include_once("../includes/core.php");
 $query = "SELECT booking.id, booking.date, users.forename, users.surname, booking.time, booking.comments, booking.confirmedbystaff, service.type, service.price 
 FROM booking 
 INNER JOIN users ON booking.username = users.username
 INNER JOIN service ON booking.service_id = service.id;
 ORDER BY booking.time ASC";
$query_params = array(
    ':date' => date("Y-m-d")
);
$db->DoQuery($query, $query_params);
$num = $db->fetchAll();
//echo "<pre>";
//echo print_r($num);
//echo "</pre>";
//if (isset($_POST['id_delete'])) 
//{
//          foreach ( $_POST['id_delete'] as $id_d) {
//            $query = "UPDATE booking SET confirmedbystaff=1 WHERE id = :id";
//            $query_params = array(
//                ':id' => $id_d
//            );
//            $db->DoQuery($query, $query_params);
//            echo("<meta http-equiv='refresh' content='1'>");
//        }
//}
if (isset($_POST['checkin_customer_id'])) 
{
            $query = "UPDATE booking SET confirmedbystaff=1 WHERE id = :id";
            $query_params = array(
                ':id' => $_POST['checkin_customer_id']
            );
            $db->DoQuery($query, $query_params);
            echo("<meta http-equiv='refresh' content='0'>");
}
if (isset($_POST['uncheck_customer_id'])) 
{
            $query = "UPDATE booking SET confirmedbystaff=0 WHERE id = :id";
            $query_params = array(
                ':id' => $_POST['uncheck_customer_id']
            );
            $db->DoQuery($query, $query_params);
            echo("<meta http-equiv='refresh' content='0'>");
}
?>

</script>
<html>
<head>
<title>Concierge - <?php echo $title; ?></title>
<meta name="apple-mobile-web-app-capable" content="yes">
<link rel="stylesheet" href="<?php echo $directory."assets/style.css";?>"/>
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
</head>
<body>
<div id="checkin_topbar">



<div class="group">
  <div class="left">
  <?php echo date("l, jS F");?><br>
	<?php echo date("g:i A");?><br>
    </div>
  <div class="right">
  <h1>Checkins</h1>
  </div>
  </div>
  <form id="tfnewsearch" method="get" action="http://www.google.com">
  		        <input type="text" class="tftextinput" name="q" size="21" maxlength="120"><input type="submit" value="search" class="tfbutton">
  		</form>
</div>
<div class="blank">

<h1>Your Upcoming Appointments.</h1>
jhasdvfashg fiasgfiuasd haush aou aoh aoish a;ois</div>
<div id="container">
<?php if(!empty($num)) { ?>
<form method='post' action='appointments.php'>
<ul id="accordion">
    
<?php 
foreach ($num as $row) {
$dtA = strtotime($row['date'] ." ". $row['time']);

$timee = date("D-d-m-y", strtotime($row['date']));

$timeg = date("g:i A", strtotime($row['time']));

if ($row['date'] == date("Y-m-d")) {
	echo '<li>';
	echo '<div id="topbox" class="base">';
	
	if ($row['confirmedbystaff'] == 1) {
		echo '<div id="indicator" class="checkedin"></div>';
	} elseif ($row['confirmedbystaff'] == 0) {
		if ($dtA <= time()-300) {
			echo '<div id="indicator" class="missing"></div>';
		} else {
			echo '<div id="indicator" class="notcheckedin"></div>';
		}
	}

	echo  '<p>'.$timeg ." - ". $row['forename']." ".$row['surname'].'</p>';
//	echo '<input class="pinToggles" type="checkbox" name="id_delete[]" value="'.$row['id'].'">';
  	echo '</div> <ul id="details">';?>
  	
  	
  	  <div class="left">
		<?php // echo $row['date']; ?><br>
		<?php echo $row['forename'] ." ". $row['surname']; ?><br>
		<?php echo $row['time']; ?><br>
		<?php echo $row['type']; ?><br>
	  </div>
  	  <div class="right">
  	  	Total Price: <?php echo '&pound;'.$row['price']; ?><br>
  	  	<?php if ($row['confirmedbystaff'] == 0) {?>
  	  	<button type="submit" name="checkin_customer_id" value="<?php echo $row['id'];?>">Checkin Customer</button>
  	  	<?php } else{?>
  	  	<button button type="submit" name="uncheck_customer_id" value="<?php echo $row['id'];?>">Uncheck</button>
  	  	<button value="<?php echo $row['id'];?>">Bill</button>
  	  	<?php }?>
  	  </div>


<?php if (!empty($row['comments'])){ 
echo '<h2>Customers Comment</h2>';
echo '<p id="checkin_comments">'.$row['comments'].'</p>'; }?><br>
  	


		</ul></li>
  	<?php
}}
echo "</ul>";
?>


<?php }
include '../includes/footer.php';
?>


<script>

$( "#accordion" ).accordion({
    animate: {
        duration: 250
    }
});
$(".pinToggles").click(function(event){
    event.stopPropagation();
});
</script>
</ul>
</form>
</body>
</html>
