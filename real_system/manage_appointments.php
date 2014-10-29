<?php 
include_once("includes/core.php");
include("functions/encryption.php");


$date = date("Y-m-d");
$query = "SELECT start, name, email, phone, comments FROM booking WHERE date >= :date";
$query_params = array(
    ':date' => $date
);
$db->DoQuery($query, $query_params);
$num = $db->fetchCustomers();


include 'includes/header.php';
?>

<header>
	<ul>
    <li><a href="manage_appointments.php">Make New Appointment</a></li>
		<li><a href="manage_appointments.php" class="active">Manage</a></li>
		<li><a href="manage_user.php">Settings</a></li>
	</ul>
</header>


<h1>Manage Appointments</h1>




<?php if (count($num) > 0): ?>
<table id="checkins_table">
  <thead>
    <tr>
      <th><?php echo implode('</th><th>', array_keys(current($num))); ?></th>
      <th>Alien</th>
    </tr>
  </thead>
  <tbody>
<?php foreach ($num as $row): array_map('htmlentities', $row); ?>
    <tr>
      <td><?php echo implode('</td><td>', $row); ?></td>
      <td><input type="checkbox" name="confirm" value="value1"><br></td>
    </tr>
<?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>

</div>


</div>
<?php 
include 'includes/footer.php';
?>




