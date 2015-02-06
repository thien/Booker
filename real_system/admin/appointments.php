<?php
$title = "Appointments";
$menutype = "admin_dashboard";
$require_admin = true;
include_once("../includes/core.php");
include("../functions/list_appointment_results.php");

$query = "SELECT booking.id, booking.date, users.forename, 
users.surname, booking.time, booking.comments, booking.confirmedbystaff, 
booking.staff_id, service.type, service.price, staff.s_forename, staff.s_surname
FROM booking INNER JOIN users ON booking.user_id = users.id
 INNER JOIN staff ON booking.staff_id = staff.id
 INNER JOIN service ON booking.service_id = service.id";
$order = " ORDER BY booking.date DESC, booking.time DESC";
$count_rows = "SELECT count(*) FROM booking";


  $date = date("d/m/Y");
  $datequery = " WHERE date = '".date("Y/m/d")."' ";

if (isset($_GET))
  if (isset($_GET['year']) & isset($_GET['month']) & isset($_GET['day']) ){
    $year = $_GET['year'];
    $month = $_GET['month'];
    $day = $_GET['day'];
    if (!empty($year) & !empty($month) & !empty($day) ){
      if (checkdate($month, $day, $year) !== true){
        array_push($errors, "The selected date is invalid, please try again.");
      } else {
        $date = $day."/".$month."/".$year;
        $datequery = " WHERE date = '".$year."-".$month."-".$day."' ";
      } 
    } else {
    array_push($errors, "Please fill in all the criteria for the date.");
   }
} 
$count_rows = $count_rows.$datequery;
$query = $query.$datequery.$order;


$db->DoQuery($count_rows);
$count = $db->fetch();

//Add following after it
$per_page =10;//define how many results per page.
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
?>

<h1>Appointments</h1>

<form action="appointments.php" method="get" class="select" id="date">
<select name="year">
  <option value="">Year</option>
  <?php 
    for ($syear = date('Y'); $syear > date('Y')-5; $syear--) { 
     echo '<option value="'.$syear.'">'.$syear.'</option>';
   } 
   ?>
</select>
<select name="month">
  <option value="">Month</option>
  <?php for ($smonth = 1; $smonth <= 12; $smonth++) {  
  if (strlen($smonth)==1) {
    echo '<option value="0'.$smonth.'">0'.$smonth.'</option>';
    } else {
    echo '<option value="'.$smonth.'">'.$smonth.'</option>';
   } 
 } 
 ?>
</select>

<select name="day">
  <option value="">Day</option>
  <?php for ($sday = 1; $sday <= 31; $sday++) {  
  if (strlen($sday)==1) {
    echo '<option value="0'.$sday.'">0'.$sday.'</option>';
    } else {
    echo '<option value="'.$sday.'">'.$sday.'</option>';
   } 
 } 
 ?>
</select>

<button type="submit">Query</button>
</form>
<?php 
if (isset($date)){
  echo '<center>Appointments on <h3>'.$date.'</h3></center>';
}
?>

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
$( ".accordion" ).accordion();
$(".pinToggles").click(function(event){
    event.stopPropagation();
});
</script>
