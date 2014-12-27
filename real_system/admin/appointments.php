<?php
$title = "Appointments";
$menutype = "admin_dashboard";
$require_admin = true;
include_once("../includes/core.php");
include("../functions/list_appointment_results.php");
$date = date("Y-m-d");
$query = "SELECT booking.id, booking.date, users.forename, 
users.surname, booking.time, booking.comments, booking.confirmedbystaff, 
booking.staff_id, service.type, service.price, staff.s_forename, staff.s_surname
FROM booking
 INNER JOIN users ON booking.username = users.username
 INNER JOIN staff ON booking.staff_id = staff.id
 INNER JOIN service ON booking.service_id = service.id 
 ORDER BY DATE(booking.date) DESC, booking.time DESC
 ";

$count_rows = "SELECT count(*) FROM booking";
$db->DoQuery($count_rows);
$count = $db->fetch();

// echo $count[0];
//Add following after it
$per_page =10;//define how many games for a page
$pages = ceil($count[0]/$per_page);

if(!isset($_GET['page'])){
$page="1";
}else{
$page=$_GET['page'];
}
$start = ($page - 1) * $per_page;
$query = $query . " LIMIT $start, $per_page";
$db->DoQuery($query);
$num = $db->fetchAll();



include '../includes/header.php';

print_r($_POST);
?>

<h1>Appointments</h1>

<form action="appointments.php" method="post">
<select name="year">
  <option value="">Year</option>
  <?php 
    for ($year = date('Y'); $year > date('Y')-5; $year--) { 
     echo '<option value="'.$year.'">'.$year.'</option>';
   } 
   ?>
</select>
<select name="month">
  <option value="">Month</option>
  <?php for ($month = 1; $month <= 12; $month++) { ?>
  <option value="<?php echo strlen($month)==1 ? '0'.$month : $month; ?>"><?php echo strlen($month)==1 ? '0'.$month : $month; ?></option>
  <?php } ?>
</select>


<select name="month">
  <option value="">Month</option>
  <?php for ($month = 01; $month <= 12; $month++) { 
   echo "<option value='".$month."'>".$month."</option>";
 } ?>
</select>



<select name="day">
  <option value="">Day</option>
  <?php for ($day = 1; $day <= 31; $day++) { ?>
  <option value="<?php echo strlen($day)==1 ? '0'.$day : $day; ?>"><?php echo strlen($day)==1 ? '0'.$day : $day; ?></option>
  <?php } ?>
</select>
<button type="submit">Query</button>
</form>


<ul id="pagination">
<?php
//Show page links
for ($i = 1; $i <= $pages; $i++)
  { 
    if ($page == $i){
     echo '<li id="active"><a href="Appointments.php?page='.$i.'">'.$i.'</a></li>';  
    } else {
      echo '<li><a href="Appointments.php?page='.$i.'">'.$i.'</a></li>';  
    }
  }
?>
</ul>


<?php
list_appointments($num);
include '../includes/footer.php';
?>


<script>
$( "#accordion" ).accordion();
$(".pinToggles").click(function(event){
    event.stopPropagation();
});
</script>
