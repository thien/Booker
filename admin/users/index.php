<?php 
include_once($_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php');
try {
	$result = $pdo->query('SELECT id, name FROM users');
} catch (PDOException $e) {
	$error = 'Error fetching users from the database!';
	include 'error.php';
	exit();
}

foreach ($result as $row)
{
	$users[] = array('id' => $row['id'], 'name' => $row['name']);
}

include 'users.php';
?>