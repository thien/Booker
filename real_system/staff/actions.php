<?php


  include("../classes/database.php");

  $db = new database;
  $db->initiate();
  
$query = "SELECT * FROM booking WHERE date >= :date";
$query_params = array(
    ':date' => date("Y-m-d")
);
$db->DoQuery($query, $query_params);
$num = $db->fetchCustomers();

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
include('db.php');
$check = mysql_query("SELECT * FROM comment order by id desc");
if(isset($_POST['content']))
{
$content=mysql_real_escape_string($_POST['content']);
$ip=mysql_real_escape_string($_SERVER['REMOTE_ADDR']);
mysql_query("insert into comment(msg,ip_add) values ('$content','$ip')");
$fetch= mysql_query("SELECT msg,id FROM comment order by id desc");
$row=mysql_fetch_array($fetch);
}
?>

<div class="showbox"> <?php echo $row['msg']; ?> </div>-->