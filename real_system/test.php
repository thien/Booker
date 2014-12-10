<?php 

include_once('includes/core.php'); 
?>


<select id='select' name='booking_service'>
<option value='selectvalue'>Please select a Service</option>

<?php
$query = "SELECT * FROM service";
$db->DoQuery($query);
$num = $db->fetchAll(PDO::FETCH_NUM);


foreach ($num as $row) {
	$text = $row[1] . " - &pound;" . $row[2];
	echo '<option value="'.$row[0].'">'.$text.'</option>';
};
?>
</select><br>
