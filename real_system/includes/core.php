<?php

$timeout = time() + 600;
//Automatic Logout Sessions
if ($require_user == true) {
	if (!$_COOKIE['userdata']['loggedin'] == 1) {
		header('Location: login.php?timeout=true');
	} else {
    //rewrite cookie with new time.
    setcookie('userdata[loggedin]', TRUE, $timeout, '', '', '', TRUE);
    setcookie('userdata[user_id]', $_COOKIE['userdata']['user_id'], $timeout, '', '', '', TRUE);
    setcookie('userdata[forename]', $_COOKIE['userdata']['forename'], $timeout, '', '', '', TRUE);
    setcookie('userdata[surname]', $_COOKIE['userdata']['surname'], $timeout, '', '', '', TRUE);
  };
};


if ($require_admin == true) {
  // echo "this page requires admin priv";
  // print_r($_COOKIE);
  if (!isset($_COOKIE['admin']['loggedin'])){ //checks if cookie is expired.
    header('Location: login.php?timeout=true'); 
   } else {
    //rewrite cookie with new time.
      setcookie('admin[loggedin]', $_COOKIE['admin']['loggedin'], $timeout, '', '', '', TRUE);
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

  // Create a new DB class, initiates on page.
  include($directory . "classes/database.php");

  if (file_exists($directory . "setup.php") && (strpos($_SERVER['SCRIPT_NAME'],'setup') == false)) {
    header("Location: setup.php");
  }

  $db = new database;
  $db->initiate();

?>
