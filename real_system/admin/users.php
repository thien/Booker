<?php 
$menutype = "admin_dashboard";
$title = "Users";  
include_once("../includes/core.php");
if (isset($_GET['usertype'])){
$usertype = $_GET['usertype'];
} else {
$usertype = 'customers';
}

if ($usertype == 'customers'){
	$query = "SELECT * FROM users";
	$db->DoQuery($query);
	$num = $db->fetchAll();
}
if ($usertype == 'staff'){
	$query = "SELECT * FROM staff";
	$db->DoQuery($query);
	$num = $db->fetchAll();
}


include($directory . '/includes/header.php');
?>
<a href="?usertype=customers">Customers</a>
<a href="?usertype=staff">Staff</a>

<?php if ($usertype =='customers'){?>
<h1>Customers</h1>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

<form method='post' action='appointments.php'>
<button>Ban</button>
	<ul id="accordion">
	<?php 
	foreach ($num as $row) {
		echo '<li>';
		echo '<div id="topbox" class="base">';
		echo '<input class="pinToggles" type="checkbox" name="id_delete[]" value="'.$row['username'].'">';
		echo  '<p>'.$row['id']." - ".$row['forename']." ".$row['surname']." (".$row['username'].")".'</p>';
	  	echo '</div><ul id="details">';?>
	  	
	  	
	  	  <div class="left">
			<?php echo $row['forename'] ." ". $row['surname']; 
			echo '<tr>';
			echo '<td>'.$row['username'].'</td>';
			echo '<td>'.$row['forename'].' '.$row['surname'].'</td>';
			echo '<td>'.$row['email'].'</td>';
			echo '<td>'.$row['phoneno'].'</td>';
			echo '<td>'.$row['activated'].'</td>';
			?>
		 </div>
	  	  <div class="right">
	  	 </div>

	
			</ul></li>
	  	<?php
	}
	?>
	</ul>
</form>
<?php }?>
<script>

$( "#accordion" ).accordion({
    animate: {
        duration: 250
    }
});
$(".pinToggles").click(function(event){
    event.stopPropagation();
});
</script>
