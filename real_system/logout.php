<?php 

$expiry = time()-60*60;
$expired = time()-9999999;
unset($_COOKIE);
setcookie('userdata[loggedin]', "", $expired);
setcookie('userdata[username]', "", $expired);
setcookie('userdata[forename]', "", $expired);
setcookie('userdata[surname]', "", $expired);
header('Location: login.php');	

?>