<?php 
  $title = "Services";
  ini_set('display_errors',1);
  ini_set('display_startup_errors',1);
  error_reporting(-1);
  
  include_once("../includes/core.php");
  
 if ($_POST) {
  $query = " INSERT INTO services (type, price, description) VALUES (:type, :price, :description)";
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
$query = "SELECT * FROM services";
$db->DoQuery($query);
$num = $db->fetchAll(PDO::FETCH_NUM);
//$roww = $db->RowCount($query);
?>
<h1>Services</h1>
<script type="text/javascript" src="../assets/jquery.js"></script>
<script src="../assets/modernizr.js"></script> 

<?php 
echo "<table id='mytable' style='width:100%'>";
echo "<tr>
		<th>Name</th>
		<th>Price</th>
		<th>Description</th>
	 </tr>";
foreach ($num as $row) {
	echo '<tr>';
    echo '<td>'.$row[1].'</td>';
    echo '<td>'.$row[2].'</td>';
    echo '<td>'.$row[3].'</td>';
    echo '<td><button name="'.$row[0].'" class="popup-trigger">Delete</button></td>';
	echo '</tr>';
	}
?>

<div class="popup" role="alert">
	<div class="popup-container">
		<p>Are you sure you want to delete this element?</p>
		<ul class="cd-buttons">
			<li><a class="delete-trigger" href="#" value="mynigga">Yes</a></li>
			<li><a href="#0" class="popup-closeo">No</a></li>
		</ul>
		<a href="#0" class="popup-close img-replace">Close</a>
	</div> 
</div> 


<form action="services.php" method="post" autocomplete="off">
<tr>
<td><input type="text" name="service_name" placeholder="Name"/></td>
<td><input type="number" name="service_price" size="4" placeholder="Price"/></td>
<td><input type="text" name="service_description" placeholder="Description"/></td>
<td><button>add</button></td>
</tr>
</form>
</table>
<script>
$(document).ready(function($){
	//open popup
	$('.popup-trigger').on('click', function(event){
		event.preventDefault();
		$('.popup').addClass('is-visible');
		$('.delete-trigger').append(($(':button').attr('name')));
		$(".delete-trigger").attr('name', 'itworked');
//		var rowCount = $('#mytable tr').length;
//		
//		for (var i = 0 to rowCount){
//		$( "ul li:nth-child(2)" ).append( "<span> - 2nd!</span>" );
//		}
		
		
	});
	//make delete
		$('.delete-trigger').on('click', function(event){
//		$.post('services.php', { idtodelete: 1231 },
//	    function(result) {
//	      $('#username_availability').html(result).show();
//	    });

		console.log($(':button').attr('name'));
	});
	
	function deletetest() {
		
	}
	
	//close popup
	$('.popup').on('click', function(event){
		if( $(event.target).is('.popup-close') || $(event.target).is('.popup-closeo') || $(event.target).is('.popup') ) {
			event.preventDefault();
			$(this).removeClass('is-visible');
		}
	});
	
	//close popup when clicking the esc keyboard button
	$(document).keyup(function(event){
    	if(event.which=='27'){
    		$('.popup').removeClass('is-visible');
	    }
    });
});
</script>
