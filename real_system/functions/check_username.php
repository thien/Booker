<?php
require( "../classes/database.php");
$db = new database();
$db->initiate();

if (isset($_POST['username'])) {
$value = $_POST['username'];
};

$query = ("SELECT username FROM users WHERE username = :username");
$query_params = array(
	':username' => $value
	);
$db->DoQuery($query, $query_params);
$rows = $db->fetch();

$pattern = '/^def/';

if ($value == NULL)
	echo '';
else if (strlen($value) <= 3)
	echo 'This username is too short!';
else {
	if ($rows >= 1)
	echo "This username isn't available.";
else if ($rows == 0)
	if (preg_match($pattern, $value, $matches, PREG_OFFSET_CAPTURE, 3) !== NULL) {
		$username_available == TRUE;
		echo "This username is available!";
	}
	else 
		echo "This username is invalid.";
}
?>
<!-- 

https://www.youtube.com/watch?v=8wUu7pWBygY -->