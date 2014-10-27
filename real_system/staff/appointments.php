<?php 

include("../includes/common.php");
$date = date("Y-m-d");
$query = "SELECT start, name, email, phone, comments FROM booking WHERE date >= :date";
$query_params = array(
    ':date' => $date
);
$db->DoQuery($query, $query_params);
$num = $db->fetchCustomers();

// echo '<pre>'; print_r($num); echo '</pre>';
include("../includes/header.php");
?>



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

<!-- 
 <?php echo '<pre>'; print_r($row); echo '</pre>'; ?> -->
