<?php 
$date = date("Y-m-d");
if (isset($_GET['name'])) {
  $user = $_GET['name'];
 include_once("../includes/core.php");
 $query = "SELECT booking.id, booking.date, users.forename, users.surname, booking.time, booking.comments, booking.confirmedbystaff, service.type, service.price 
 FROM booking 
 INNER JOIN users ON booking.username = users.username
 INNER JOIN service ON booking.service_id = service.id
 WHERE booking.date = :date AND users.forename like :user OR users.surname like :user
 ORDER BY booking.time ASC";
$query_params = array(
    ':date' => date("Y-m-d"),
    ':user' => $_GET['name']
);
$db->DoQuery($query, $query_params);
$num = $db->fetchAll();

}
?>

<link rel="stylesheet" href="<?php echo $directory."assets/style.css";?>"/>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>


<?php 

if(!empty($num)) { 
  echo "<form method='post' action='appointments.php'>";
  echo "<ul id='accordion'>";
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
      echo '</div>';
      echo '<ul id="details">';
        echo '<div class="left">';
          echo $row['forename'] ." ". $row['surname'].'<br>';
          echo $row['time'].'<br>';
          echo $row['type'].'<br>';
        echo '</div>';
        echo '<div class="right">';
            echo 'Total Price: &pound;'.$row['price'].'<br>';
               if ($row['confirmedbystaff'] == 0) {
                  echo '<button type="submit" name="checkin_customer_id" value="'.$row['id'].'">Checkin Customer</button>';
             } else {
                echo '  <button button type="submit" name="uncheck_customer_id" value="'.$row['id'].'">Uncheck</button>';
                echo '  <button value="'.$row['id'].'">Bill</button>';
             }
        echo '</div>';
        if (!empty($row['comments'])){ 
          echo '<h2>Customers Comment</h2>';
          echo '<p id="checkin_comments">'.$row['comments'].'</p><br>'; 
        }
      echo '</ul>';
      echo'</li>';
    }
  }
  echo "</ul>";
} elseif (empty($num)) {
  echo "<h1>Nothing was found.</h1>";
  echo "Time to relax!";
}
echo "</ul></form>";
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
    <script type="text/javascript">
function makeAjaxRequest() {
    $.ajax({
        url: '/includes/search.php',
        type: 'get',
        data: {name: $('input#name').val()},
        success: function(response) {
            $('content').html(response);
        }
    });
}
  </script>