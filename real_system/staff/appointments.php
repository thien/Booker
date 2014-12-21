<?php 
$title = "Checkin";
 include_once("../includes/core.php");
 $query = "SELECT booking.id, booking.date, users.forename, users.surname,
  booking.time, booking.comments, booking.confirmedbystaff, booking.staff_id, service.type, service.price 
 FROM booking 
 INNER JOIN users ON booking.username = users.username
 INNER JOIN service ON booking.service_id = service.id
 WHERE booking.date = :date
 ORDER BY booking.time ASC";
$query_params = array(
    ':date' => date("Y-m-d")
);
$db->DoQuery($query, $query_params);
$num = $db->fetchAll();

if (isset($_POST['checkin_customer_id'])) 
{
  $query = "UPDATE booking SET confirmedbystaff=1, staff_id=:staff_id WHERE id = :id";
  $query_params = array(
      ':staff_id' => $_COOKIE['staff']['id'],
      ':id' => $_POST['checkin_customer_id']
  );
  $db->DoQuery($query, $query_params);
  echo("<meta http-equiv='refresh' content='0'>");
}

if (isset($_POST['uncheck_customer_id'])) 
{
  $query = "UPDATE booking SET confirmedbystaff=0, staff_id = :staff_id WHERE id = :id";
  $query_params = array(
      ':staff_id' => NULL,
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
   <?php echo $_COOKIE['staff']['forename']." ".$_COOKIE['staff']['surname'];?>
    </div>
  <div class="right">
  <h1>Checkins</h1>
  </div>
  </div>





<form method="post" action="<?PHP echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="on" id="forms"> 
  <input id="username_" name="username" type="text" placeholder="Search"/>
</form>




</div>
<div class="blank"></div>
<div id="container">



<?php 
include("../functions/list_appointment_results.php");
  if (!empty($num)) {
    list_appointments($num);
  }
  elseif (empty($num)) {
  echo "<h1>There's no appointments today.</h1>";
  echo "Time to relax!";
}
include '../includes/footer.php';
?>
</div>
<script>
$("#accordion").accordion({
    animate: {
        duration: 250
    }
});
$(".pinToggles").click(function(event){
    event.stopPropagation();
});
</script>


<script type="text/javascript">
$(document).ready(function() {
  var originalState = $("#container").html();
  $('#username_').keyup(function() {
    var value = $("#username_").val(); 
    console.log(value);
    if (value.length > 1) {
    $.post('/functions/search_appointments.php', { username: forms.username.value },
      function(result) {
        $('#container').html(result).show();
      });
    } else {
        $("#container").html(originalState);
    }
  });    
});
</script>
