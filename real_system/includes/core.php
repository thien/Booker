<?php
  /**
    includes/core.php - common code to be included in every page.
    This library connects to the database and starts the session.
  **/

//Automatic Logout Sessions
if ($require_user == true) {
	if (!$_COOKIE['userdata']['loggedin'] == 1) {
		header('Location: login.php?timeout=true');
	};
};


// Generic Expiry Time for Cookies.
$expiry = time() + (60*10);

$admin_expiry = time() + 10;
if ($require_admin == true) {
  // echo "this page requires admin priv";
  // print_r($_COOKIE);
  if (!isset($_COOKIE['admin']['loggedin'])){ //checks if cookie is expired.
    header('Location: login.php?timeout=true'); 
   } else {
    //rewrite cookie with new time.
      $staff_expiry = time() + 60;
      setcookie('admin[loggedin]', $_COOKIE['admin']['loggedin'], $staff_expiry, '', '', '', TRUE);
   }
}

//Display PHP Errors (Used for Debugging and Development)
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

//Directory Variable used to handle difficulty in directory linking
	if ((strpos($_SERVER['SCRIPT_NAME'],'admin') !== false) OR strpos($_SERVER['SCRIPT_NAME'],'staff') !== false OR strpos($_SERVER['SCRIPT_NAME'],'/includes/search.php') !== false) {
		$directory = "../"; 
		} else {
		$directory = ""; 
		}

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
  $errors = array();
  $update = array();


  function display_errors($errors = array()) {
    if (!empty($errors)){
        foreach ($errors as $msg){
          echo '<div class="error">';
          echo $msg;
          echo "</div>";
        }
      }
  }
    function display_updates($message = array()) {
    if (!empty($message)){
        foreach ($message as $msg){
          echo "<div class='update'>";
          echo $msg;
          echo "</div>";
        }
      }
  }

  // function disable_enter(){
  //   echo "<script>
  //         $('html').bind('keypress', function(e)
  //         {
  //            if(e.keyCode == 13)
  //            {
  //               return false;
  //            }
  //         });
  //         </script>
  //         "
  // }

  //Salt
  // $salt = "b18237y419v2by4190vb";	


  // Create a new DB class and run the init routine
  include($directory . "classes/database.php");

  $db = new database;
  $db->initiate();

?>
