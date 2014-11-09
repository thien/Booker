<?php 
$title = 'Profile';
include_once("includes/core.php");
include("functions/encryption.php");


$date = date("Y-m-d");
$query = "SELECT * FROM users WHERE username = :username";
$query_params = array(
    ':username' => $_COOKIE['userdata']['username']
);
$db->DoQuery($query, $query_params);
$q = $db->fetch();


include 'includes/header.php';
?>

<h1>Your Information.</h1>

<div id="left">
<?php
	echo '<b>Username</b>  '.$q['username'].'<br>';
    echo '<b>Name</b>  '.$q['forename'].' '.$q['surname'].'<br>';
    echo '<b>Email</b>  '.$q['email'].'<br>';
    echo '<b>Phone No.</b>  '.$q['phoneno'].'<br>';
?>
</div>
<div id="right">
<p align="right">
<a href="edit.php">Edit</a>
</p>
</div>
<?php 
include 'includes/footer.php';
?>




