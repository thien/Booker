<?php
function list_appointments($num = array()) {
if(!empty($num)) { 
  echo "<form method='post' action='appointments.php'>";
  echo "<ul id='accordion'>";
  foreach ($num as $row) {
    echo '<li>';
    echo '<div id="topbox" class="base">';
    if ($row['confirmedbystaff'] == 1) {
      echo '<div id="indicator" class="checkedin"></div>';
    } elseif ($row['confirmedbystaff'] == 0) {
      if (strtotime($row['date'] ." ". $row['time']) <= time()-300) {
        echo '<div id="indicator" class="missing"></div>';
      } else {
        echo '<div id="indicator" class="notcheckedin"></div>';
      }
    }
    echo '<p>'.date("g:i A", strtotime($row['time']))." - ". $row['date'] ." - ". $row['forename']." ".$row['surname'].'</p>';
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
              echo '  <button value="'.$row['id'].'">Bill</button><br>';
              echo '  Checked in by '.$row['s_forename']." ".$row['s_surname'];
              
           }
      echo '</div>';
      if (!empty($row['comments'])){ 
        echo '<h2>Customers Comment</h2>';
        echo '<p id="checkin_comments">'.$row['comments'].'</p><br>'; 
      }
    echo '</ul>';
    echo'</li>';
    }
  echo "</ul>";
} elseif (empty($num)) {
  echo "<h1>Nothing was found here..</h1>";
  echo "Try searching for their forename or surname.";
}
echo "</ul></form>";
}
?>