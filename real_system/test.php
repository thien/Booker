<?php 
echo $_SERVER['PHP_SELF'];
$mystring = $_SERVER['PHP_SELF'];
$findme = 'admin';
$pos = strpos($mystring, $findme);
if ($pos === false) {
    echo "The string '$findme' was not found in the string '$mystring'";
} else {
    echo "The string '$findme' was found in the string '$mystring'";
    echo " and exists at position $pos";
}
//		echo strpos($_SERVER['PHP SELF'],'admin');
?>
