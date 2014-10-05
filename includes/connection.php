<?php 
try {
	$pdo = new PDO('mysql:host=localhost;dbname=cms', 'thien', 'JmuVnBrLxqAFTEhA');
} 
catch (PDOException $e)
{
	$error = 'Unable to connect to the dataase server.';
	include 'error.php';
	exit();
}
?>