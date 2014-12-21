<?php
function list_appointments($num = array(), $parameters = array()) {
if(!empty($num)) { 
  echo "<form method='post' action='appointments.php'>";
  echo "<ul id='accordion'>";
  foreach ($num as $row) {
    $dtA = strtotime($row['date'] ." ". $row['time']);
    $timee = date("D-d-m-y", strtotime($row['date']));
    $timeg = date("g:i A", strtotime($row['time']));

    if ($row['date'] == date("Y-m-d")) {
      show_appointments_results($row);
    }
  }
  echo "</ul>";
} elseif (empty($num)) {
  echo "<h1>Nothing was found for this query.</h1>";
  echo "Try searching for their forename or surname.";
}
echo "</ul></form>";
}


function show_appointments_results($row = array()){
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
?>