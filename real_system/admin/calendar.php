<?php 
$title = "Calendar";
$menutype = "admin_dashboard";

include_once("../includes/core.php");

if (isset($_POST)) {

  if (isset($_POST['closing_date'])){
    $date = $_POST['closing_date'];
  }
    if (isset($_POST['id'])){
    $id = $_POST['id'];
  }

  if (isset($_POST['new'])) {
    $query = "INSERT INTO closed_days (date) VALUES (:date)";
    $query_params = array(
    ':date' => $date
    );
    $db->DoQuery($query, $query_params);
      header("Location: Calendar.php?updated=1");
  } elseif(isset($id)){
    $query = "DELETE FROM closed_days WHERE id = :id";
    $query_params = array(
    ':id' => $id
    );
    $db->DoQuery($query, $query_params);
      header("Location: Calendar.php?updated=1");
  }

}



include($directory . '/includes/header.php');
$query = "SELECT * FROM closed_days";
$db->DoQuery($query);
$num = $db->fetchAll(PDO::FETCH_NUM);
//$roww = $db->RowCount($query);



?>
<h1>Calendar</h1>

<h2>Manage Closing Days</h2>

<?php

if (isset($_GET['updated']) && $_GET['updated'] == 1){
  echo "<div class='updated' id='status'>Your information has been updated into the database.</div>";
}

echo "<table id='mytable' style='width:100%'>";
foreach ($num as $row) {
  echo '<form action="" method="post" autocomplete="off">';
  echo '<tr>';
    echo '<td><input type="text" name="closing_date" placeholder="Name" value="'.$row['date'].'"/></td>';
    echo '<td><button value="'.$row[0].'" name="id">Remove</button></td>';
  echo '</tr>';
  echo '</form>';
  }
?>
</form>
<form action="" method="post" autocomplete="off">
<tr>
<td><input type="date" name="closing_date" placeholder="Today?"/></td>
<td><input type="submit" name="new" value="Add"></td>
</tr>
</form>
</table>



