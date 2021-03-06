<?php
$title = "Setup";
require("includes/core.php");
require("functions/encryption.php");

if (isset($_POST['username'])) {

  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  $password_again = trim($_POST['password_again']);
  $email = trim($_POST['email']);

  if (!filter_var($email, FILTER_VALIDATE_EMAIL))
  array_push($errors, "Please specify a valid email address");

  if (strlen($username) == 0){
    array_push($errors, "Please enter a username.");
  } else {
    if (ctype_alnum($username) !== true){
      array_push($errors, "Please enter a valid username.");
    }
  }


  if (strlen($password) < 5)
  array_push($errors, "Please enter a password. Passwords must contain at least 5 characters.");

  if (isset($password_again)) {
    if ($password !== $password_again)
    array_push($errors, "The passwords do not match.");
  } else {
    array_push($errors, "Please repeat your password.");
  }

  // If no errors were found, proceed with storing the user input
  if (count($errors) == 0) {
    $password = encrypt($password);
    $create_table = array(
              "CREATE TABLE `admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;",
              
              "CREATE TABLE `closed_days` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;",
  "CREATE TABLE `metadata` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `option` varchar(255) DEFAULT '',
  `value` varchar(255) DEFAULT NULL,
  `description` text,
  `rule` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;",
              "CREATE TABLE `service` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(25) DEFAULT NULL,
  `price` int(5) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;",
              "CREATE TABLE `staff` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pin` varchar(128) DEFAULT NULL,
  `s_forename` varchar(25) DEFAULT NULL,
  `s_surname` varchar(25) DEFAULT NULL,
  `s_email` varchar(100) DEFAULT NULL,
  `banned` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;",
              "CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(55) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `forename` char(55) DEFAULT NULL,
  `surname` char(55) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phoneno` varchar(11) DEFAULT NULL,
  `activated` tinyint(1) DEFAULT NULL,
  `banned` tinyint(1) DEFAULT NULL,
  `activation_code` varchar(128) DEFAULT NULL,
  `forgot_code` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;", 


"CREATE TABLE `booking` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `comments` text COLLATE utf8_unicode_ci NOT NULL,
  `confirmedbystaff` tinyint(1) DEFAULT NULL,
  `service_id` int(11) unsigned DEFAULT NULL,
  `staff_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `service_id` (`service_id`),
  KEY `booking_ibfk_2` (`staff_id`),
  KEY `idx_user_id` (`user_id`) USING BTREE,
  CONSTRAINT `booking_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`),
  CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;",
    );

    for ($x = 0; $x <= 6; $x++) {
      switch ($x) {
        case 0:
            $table_name = "admin";
            break;
        case 1:
            $table_name = "closed_days";
            break;
        case 2:
            $table_name = "metadata";
            break;
        case 3:
            $table_name = "service";
            break;
        case 4:
            $table_name = "staff";
            break;
        case 5:
            $table_name = "users";
            break;   
        case 6:
            $table_name = "booking";
            break;  
      }
      $check_if_exists = "SHOW TABLES LIKE '$table_name'";
      $db->doQuery($check_if_exists);
      $fetch = $db->fetch();
      if (!$fetch) {
          $db->doQuery($create_table[$x]);
      } 
    }

  $insert_base_queries = array(
      "INSERT INTO `metadata` (`id`, `option`, `value`, `description`, `rule`) VALUES
      (1, 'opening_time', '10:00', 'The time of the first slot', 'Opening Time'),
      (2, 'closing_time', '19:30', 'The time of the last slot', 'Closing Time'),
      (3, 'booking_frequency', '30', 'The amount of slots per hour, expressed in minutes.', 'Booking Frequency'),
      (5, 'business_name', 'Nails Club', 'The name of the business.', 'Business Name'),
      (6, 'business_slogan', 'is it a mad ting', 'The slogan of the business.', 'Business Slogan');
      ",
      "INSERT INTO `admin` (`username`, `password`, `email`) VALUES ('$username', '$password', '$email');",
      "INSERT INTO `service` (`id`, `type`, `price`, `description`)
VALUES
  (1, 'Manicure', 25, 'A luxurious beauty treatment for the fingernails and hands which includes perfectly-polished nails.'),
  (2, 'Infil', 26, 'A infill.'),
  (3, 'Pedicure', 29, 'A pedicure.'),
  (4, 'Full Set', 48, 'Manicure & Pedicure.'),
  (5, 'File & Polish', 15, 'A File & Polish'),
  (6, 'Nail Repair', 10, 'A Nail Repair.')
",
        "INSERT INTO `staff` (`id`, `pin`, `s_forename`, `s_surname`, `s_email`)
VALUES
  (1, NULL, NULL, NULL, NULL);
"
    );

    foreach ($insert_base_queries as $query) {
        $db->doQuery($query);
    }
      header('Location: setup.php?done');
  }
}
array_push($update, "<h1>Warning</h1>Please delete this file (setup.php) when you are finished with this page. This is necessary to improve the security of this program. Also, the program will not work until the setup is completed.");
include_once("includes/header.php");
?>

<?php 
if(isset($_GET['done'])){
    echo "<h1>All Ready to go!</h1>";
        echo "<h2>Setup is now complete!</h2>";
    echo "Customers will be able to access your booking system at <a href='http://".$_SERVER['SERVER_NAME']."'>http://".$_SERVER['SERVER_NAME']."</a>.<br>";
    echo "Staff will be able to access checkins at <a href='http://".$_SERVER['SERVER_NAME']."/staff'>http://" . $_SERVER['SERVER_NAME'] ."/staff" ."</a>.<br>";
    echo "You, the Administrator, will be able to access settings at <a href='http://".$_SERVER['SERVER_NAME']."/admin'>http://" . $_SERVER['SERVER_NAME'] ."/admin" ."</a>.<br>";
    echo "It is now safe to delete this (setup.php) file.";
} else {
?>
<h1>Setup Administrator's Account</h1>

You'll need to create a account to get into the Administrators Dashboard. 
<form action="" method="post" autocomplete="off">
<input type="text" name="username" placeholder="Username"/>
<input type="password" name="password" placeholder="Password">
<input type="password" name="password_again" placeholder="Password Again">
<input type="email" name="email" placeholder="Email">
<button type="submit">Submit</button>
</form>
<?php };?>
