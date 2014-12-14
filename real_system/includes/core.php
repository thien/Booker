<?php
  /**
    includes/core.php - common code to be included in every page.
    This library connects to the database and starts the session.
  **/

if ($require_user == true) {
	if (!$_COOKIE['userdata']['loggedin'] == 1) {
		header('Location: login.php');
	};
};

//Display PHP Errors (Used for Debugging and Development)
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

//Directory Variable used to handle difficulty in directory linking
	if ((strpos($_SERVER['SCRIPT_NAME'],'admin') !== false) OR strpos($_SERVER['SCRIPT_NAME'],'staff') !== false) {
		$directory = "../"; 
		} else {
		$directory = ""; 
		}


// echo $_SERVER['HTTP_REFERER'];

// Expiry Time for Cookies.
  $expiry = time() + (60*60*24);

include_once($directory . 'assets/recaptcha_values.php');

  // A function to enable HTTPS if it isn't on
  function forceHTTPS()
  {
    $httpsURL = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    if(!isset($_SERVER['HTTPS']) or $_SERVER['HTTPS'] !== 'on')
    {
      header("Location: $httpsURL");
      die();
    }
  }

  // A function to disable HTTPS if it is on
  function forceHTTP()
  {
    $httpURL = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    if(isset($_SERVER['HTTPS']) or $_SERVER['HTTPS'] == 'on')
    {
      header("Location: $httpURL");
      die();
    }
  }

  // Sets PHP to force use UTF8
  mb_internal_encoding("UTF-8");

  // Make sure the timezone is GMT for the date() function
  date_default_timezone_set("GMT");

  // Include Error Handler
  include($directory . "functions/errors.php");

  //Salt
  // $salt = "b18237y419v2by4190vb";	
	
  // Create a new DB class and run the init routine
  include($directory . "classes/database.php");

  $db = new database;
  $db->initiate();

?>
