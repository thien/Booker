<?php 
  $title = "Calendar";
$menutype = "admin_dashboard";
  include_once("../includes/core.php");
  
 if ($_POST['delete']) {
  $query = " INSERT INTO service (type, price, description) VALUES (:type, :price, :description)";
  $query_params = array(
  ':type' => $_POST['service_name'],
  ':price' => $_POST['service_price'],
  ':description' => $_POST['service_description']
  );
  $db->DoQuery($query, $query_params);
  header("Location: services.php");
  } 
  
//  if (isset($_POST['idtodelete'])) {
//  $deleteid = $_POST['idtodelete'];
//  echo $deleteid;
//  } 

include($directory . '/includes/header.php');
$query = "SELECT * FROM service";
$db->DoQuery($query);
$num = $db->fetchAll(PDO::FETCH_NUM);
//$roww = $db->RowCount($query);
?>
<h1>Calendar</h1>

Set closing Days
<?php 
echo "<table id='mytable' style='width:100%'>";
echo "<tr>
		<th>Day</th>
		<th>Time</th>
		<th>All Day?</th>
	 </tr>";
foreach ($num as $row) {
	echo '<tr>';
    echo '<td><input type="number" name="service_price" size="4" placeholder="Price"/></td>';
    echo '<td><input type="number" name="service_price" size="4" placeholder="Price"/></td>';
    echo '<td><input type="number" name="service_price" size="4" placeholder="Price"/></td>';
    echo '<td><button name="'.$row[0].'" name="delete" class="popup-trigger">Delete</button></td>';
	echo '</tr>';
	}
?>

<!--
<form action="services.php" method="post" autocomplete="off">
<tr>
<td><input type="text" name="service_name" placeholder="Name"/></td>
<td><input type="number" name="service_price" size="4" placeholder="Price"/></td>
<td><input type="text" name="service_description" placeholder="Description"/></td>
<td><button>add</button></td>
</tr>-->
</form>
</table>
