<?php
function list_appointments($num = array()) {
if(!empty($num)) { 
  echo "<form method='post' action='appointments.php'>";
  echo "<ul class='accordion'>";
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
    echo '<p>'.date("g:i A", strtotime($row['time']))." - ". $row['forename']." ".$row['surname'].'</p>';
    echo '</div>';
    echo '<ul id="group">';
      echo '<div id="left">';
        echo $row['forename'] ." ". $row['surname'].'<br>';
        echo $row['time'].'<br>';
        echo $row['type'].'<br>';
      echo '</div>';
      echo '<div id="right">';
          echo 'Total Price: &pound;'.$row['price'].'<br>';


          if ($row['confirmedbystaff'] == 1){
            echo '  Checked in by '.$row['s_forename']." ".$row['s_surname'] . "<br>";
          }

          if (isset($_COOKIE['staff'])){
             if ($row['confirmedbystaff'] == 0) {
                echo '<button type="submit" name="checkin_customer_id" value="'.$row['id'].'">Checkin</button>';
             } else {
                echo '  <button button type="submit" name="uncheck_customer_id" value="'.$row['id'].'">Uncheck</button>';
                echo '  <button value="'.$row['id'].'">Bill</button><br>';
             }
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