<?php 
$title = "Services";
$menutype = "admin_dashboard";
$require_admin = true;

include_once("../includes/core.php");


if (isset($_POST)) {

  if (isset($_POST['service_type'])){
    $type = $_POST['service_type'];
    if (strlen($type) < 1){
      array_push($errors, "Please type in a type.");
    }
  }
  if (isset($_POST['service_price'])){
    $price = $_POST['service_price'];
    if (strlen($price) < 1){
      array_push($errors, "Please type in a price.");
      }
  }
  if (isset($_POST['service_description'])){
    $description = $_POST['service_description'];
    if (strlen($description) < 1){
      array_push($errors, "Please type in a description.");
      }
  }
  if (isset($_POST['service_id_update'])){
    $id = $_POST['service_id_update'];
  }
  if (isset($_POST['service_id_delete'])){
    $id = $_POST['service_id_delete'];
  }

  if (isset($_POST['new'])) {
    if (count($errors) == 0) {
    $query = "INSERT INTO service (type, price, description) VALUES (:type, :price, :description)";
    $query_params = array(
    ':type' => $type,
    ':price' => $price,
    ':description' => $description
    );
    $db->DoQuery($query, $query_params);
      array_push($update, 'The query has been added.');
    }
  } elseif(isset($_POST['service_id_update'])){
    if (count($errors) == 0) {
      $query = "UPDATE service SET type = :type, description = :description, price = :price WHERE id = :id";
      $query_params = array(
      ':type' => $type,
      ':description' => $description,
      ':price' => $price,
      ':id' => $id
      );
      $db->DoQuery($query, $query_params);
      array_push($update, 'The service has been updated.');
    }
  }  elseif(isset($_POST['service_id_delete'])){

    $query = "SELECT service_id FROM booking WHERE service_id = '$id'";
    $db->DoQuery($query);
    $num = $db->fetchAll();
    if (!empty($num)){
      array_push($errors, 'This service is used by a customer. It is no longer able to be deleted.');
    } else {
      $query = "DELETE FROM service WHERE id = '$id'";
      $db->DoQuery($query);
      array_push($update, 'The service has been deleted.');
    }
  }

}



include($directory . '/includes/header.php');
$query = "SELECT * FROM service";
$db->DoQuery($query);
$num = $db->fetchAll(PDO::FETCH_NUM);



?>
<h1>Services</h1>

<?php


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
    echo '<td><input id="price" type="number" name="service_price" placeholder="value" value='.$row['price'].'></td>';
    echo '<td><textarea id="description" type="text" name="service_description" placeholder="Description"/>'.$row['description'].'</textarea></td>';
    echo '<td><button value="'.$row[0].'" name="service_id_update">Update</button></td>';
    echo '<td><button value="'.$row[0].'" name="service_id_delete">Remove</button></td>';
  echo '</tr>';
  echo '</form>';
  }
?>
</form>
<form action="services.php" method="post" autocomplete="off">
<tr>
<td><input type="text" name="service_type" placeholder="Name"/></td>
<td><input  id="price" type="number" name="service_price" size="4" placeholder="Price"/></td>
<td><textarea id="description"  type="text" name="service_description" placeholder="Description"/></textarea></td>
<td><input type="submit" name="new" value="Add"></td>
</tr>
</form>
</table>



