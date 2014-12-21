<?php 

// $expiry = time()-60*60;
// $expired = time()-9999999;
// unset($_COOKIE);
// setcookie('userdata[loggedin]', "", $expired);
// setcookie('userdata[username]', "", $expired);
// setcookie('userdata[forename]', "", $expired);
// setcookie('userdata[surname]', "", $expired);

// unset cookies
if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-1000);
        setcookie($name, '', time()-1000, '/');
    }
}

header('Location: login.php');	

?>