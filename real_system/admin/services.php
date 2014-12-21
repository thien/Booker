<?php 
  

$title = "Services";
$menutype = "admin_dashboard";

include_once("../includes/core.php");


if (isset($_POST)) {

  if (isset($_POST['service_type'])){
    $type = $_POST['service_type'];
  }
  if (isset($_POST['service_price'])){
    $price = $_POST['service_price'];
  }
  if (isset($_POST['service_description'])){
    $description = $_POST['service_description'];
  }
  if (isset($_POST['service_id'])){
    $id = $_POST['service_id'];
  }

  if (isset($_POST['new'])) {
    $query = "INSERT INTO service (type, price, description) VALUES (:type, :price, :description)";
    $query_params = array(
    ':type' => $type,
    ':price' => $price,
    ':description' => $description
    );
    $db->DoQuery($query, $query_params);
      header("Location: services.php?updated=1");
  } elseif(isset($id)){
    $query = "UPDATE service SET type = :type, description = :description, price = :price WHERE id = :id";
    $query_params = array(
    ':type' => $type,
    ':description' => $description,
    ':price' => $price,
    ':id' => $id
    );
    $db->DoQuery($query, $query_params);
      header("Location: services.php?updated=1");
  }

}



include($directory . '/includes/header.php');
$query = "SELECT * FROM service";
$db->DoQuery($query);
$num = $db->fetchAll(PDO::FETCH_NUM);
//$roww = $db->RowCount($query);



?>
<h1>Services</h1>

<?php

if (isset($_GET['updated']) && $_GET['updated'] == 1){
  echo "<div class='updated' id='status'>Your information has been updated into the database.</div>";
}

echo "<table id='mytable' style='width:100%'>";
echo "<tr>
    <th>Option</th>
    <th>Value (£)</th>
    <th>Description</th>
   </tr>";
foreach ($num as $row) {
  echo '<form action="services.php" method="post" autocomplete="off">';
  echo '<tr>';
    echo '<td><input type="text" name="service_type" placeholder="Name" value="'.$row['type'].'"/></td>';
    echo '<td><input type="number" name="service_price" placeholder="value" value='.$row['price'].'></td>';
    echo '<td><textarea id="description" type="text" name="service_description" placeholder="Description"/>'.$row['description'].'</textarea></td>';
    echo '<td><button value="'.$row[0].'" name="service_id">Update</button></td>';
  echo '</tr>';
  echo '</form>';
  }
?>
</form>
<form action="services.php" method="post" autocomplete="off">
<tr>
<td><input type="text" name="service_type" placeholder="Name"/></td>
<td><input type="number" name="service_price" size="4" placeholder="Price"/></td>
<td><input type="text" name="service_description" placeholder="Description"/></td>
<td><input type="submit" name="new" value="Add"></td>
</tr>
</form>
</table>



