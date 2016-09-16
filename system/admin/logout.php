<?php 

$expiry = time()-60*60;
$expired = time()-9999999;
unset($_COOKIE);
setcookie('admin[loggedin]', "", $expired);
header('Location: login.php');	

?>