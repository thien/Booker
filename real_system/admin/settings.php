<?php 
$menutype = "admin_dashboard";
  $title = "Settings";  
  include_once("../includes/core.php");


include($directory . '/includes/header.php');
$query = "SELECT * FROM metadata";
$db->DoQuery($query);
$num = $db->fetchAll(PDO::FETCH_NUM);
//$roww = $db->RowCount($query);
?>
<h1>Settings</h1>
<script type="text/javascript" src="../assets/jquery.js"></script>
<script src="../assets/modernizr.js"></script> 

<?php 
echo "<table id='mytable' style='width:100%'>";
echo "<tr>
		<th>Option</th>
		<th>Value</th>
		<th>Description</th>
	 </tr>";
foreach ($num as $row) {
	echo '<tr>';
    echo '<td>'.$row['rule'].'</td>';
    echo '<td><input type="text" name="service_name" size="10" placeholder="Name" value='.$row['value'].'></td>';
    echo '<td>'.$row['description'].'</td>';
    echo '<td><button name="'.$row[0].'" class="popup-trigger">Update</button></td>';
	echo '</tr>';
	}
?>
<!--<form action="services.php" method="post" autocomplete="off">
<tr>
<td><input type="text" name="service_name" placeholder="Name"/></td>
<td><input type="number" name="service_price" size="4" placeholder="Price"/></td>
<td><input type="text" name="service_description" placeholder="Description"/></td>
<td><button>add</button></td>
</tr>
</form>-->
</table>

