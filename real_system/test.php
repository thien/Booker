<?php 
include_once("includes/common.php");

$query = "SELECT forename, surname FROM client WHERE username = :username";
$query_params = array(
':username' => 'potato123'
);
$db->DoQuery($query, $query_params);
$num2 = $db->fetch();
print_r($num2);
echo '<br><br><br><br><br>';
echo $num2[0];
echo $num2[1];
?>
