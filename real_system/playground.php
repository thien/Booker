<?php 
include_once('functions/encryption.php'); 

$string = "password";
$string2 = "password2";

echo "<pre>";
echo "Testing encryption function with string: ". $string;
echo "<br>Result: " . encrypt($string);
echo "<br><br>";
echo "Testing encryption function with string: ". $string2;
echo "<br>Result: " . encrypt($string2);
echo "</pre>";
?>