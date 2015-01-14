<?php 
$title = 'Welcome';
if (!$_COOKIE['userdata']['loggedin'] == 1) {
	header('Location: login.php');
} else {
	header("refresh: 200; url=index.php");
};
include_once('includes/core.php'); 
echo '<link rel="stylesheet" href="'.$directory."assets/style.css".'"><br><br><br><br>';
echo '<div id="container"><center><p>';
echo "Welcome <b>" . $_COOKIE['userdata']['forename']."</b>.";
echo "<br>Please wait while we redirect you to the menu.";
echo "<br>Alternatively you can click <a href='index.php'>here</a> if you're not being redirected.";
echo '</p></center></div>';
?>