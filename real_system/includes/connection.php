<?php 

$user="thien";
$password="JmuVnBrLxqAFTEhA";

try {
	$pdo = new PDO('mysql:host=localhost;dbname=booking', $user, $password);
} 
catch (PDOException $e)
{
	$error = 'Unable to connect to the database server.';
	include 'error.php';
	exit();
}
?>