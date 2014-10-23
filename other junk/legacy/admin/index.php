<?php 

session_start();
include_once('../includes/connection.php');
if (isset($_SESSION['logged_in'])) {
	//if true, show admin index
	
?>
	<html>
		<head>
			<title>
			Maths Homepage - Woodhouse College
			</title>
		<?php include 'header.php';?>
		<p><?= breadcrumbs(' > ') ?></p>
		<h2><a href="index.php" id="logo">Dashboard</a></h2>
				
		<br>
		<ul>
			<li><a href="../">Site Index</a></li>
			<li><a href="add.php">Add Article</a></li>
			<li><a href="delete.php">Delete Article</a></li>
			<li><a href="upload">Upload Files</a></li>
		</ul>

		</div>
		</body>
	</html>
<?php	
} else {
	header('Location: ../admin/login.php');	
	$error = 'You need to login!';
}
?>