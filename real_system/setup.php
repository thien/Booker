<?php
require( "classes/database.php");
$db = new database();
$db->initiate();

if (isset($_POST['username']) & isset($_POST['password']) & isset($_POST['password_again'])) {
  $create_table = array(
  "CREATE TABLE `admin` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `username` varchar(11) DEFAULT NULL,
    `password` varchar(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;",
  "CREATE TABLE `booking` (
    `id` int(100) NOT NULL AUTO_INCREMENT,
    `date` date NOT NULL,
    `time` time NOT NULL,
    `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
    `comments` text COLLATE utf8_unicode_ci NOT NULL,
    `confirmedbystaff` tinyint(1) DEFAULT NULL,
    `service_id` int(11) DEFAULT NULL,
    `staff_id` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=MyISAM AUTO_INCREMENT=160 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;",
  "CREATE TABLE `closed_days` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `date` date DEFAULT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;",
  "CREATE TABLE `metadata` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `option` varchar(255) DEFAULT '',
    `value` varchar(255) DEFAULT NULL,
    `description` text,
    `rule` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;",
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
    PRIMARY KEY (`id`)
  ) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;",
  "CREATE TABLE `users` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `username` varchar(55) DEFAULT NULL,
    `password` varchar(255) DEFAULT NULL,
    `forename` char(55) DEFAULT NULL,
    `surname` char(55) DEFAULT NULL,
    `email` varchar(255) DEFAULT NULL,
    `phoneno` decimal(11,0) DEFAULT NULL,
    `activated` tinyint(1) DEFAULT NULL,
    `isadmin` tinyint(1) DEFAULT NULL,
    `activation_code` varchar(128) DEFAULT NULL,
    `forgot_code` varchar(128) DEFAULT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;",
  );
  // echo '<pre>';
  // print_r($create_table);
  // echo '</pre>';



  for ($x = 0; $x <= 6; $x++) {

      switch ($x) {
      case 0:
          $table_name = "admin";
          break;
      case 1:
          $table_name = "booking";
          break;
      case 2:
          $table_name = "closed_days";
          break;
      case 3:
          $table_name = "metadata";
          break;
      case 4:
          $table_name = "service";
          break;
      case 5:
          $table_name = "staff";
          break;
      case 6:
          $table_name = "users";
          break;     
      }

      // echo $table_name . "<br>";
      $check_if_exists = "SHOW TABLES LIKE '$table_name' ";
      $db->doQuery($check_if_exists);
      $fetch = $db->fetch();
      if (!$fetch) {
          echo $table_name . " does not exist. <br>";
          $db->doQuery($create_table[$x]);
          echo $table_name . " has been built for you. <br>";
      } else {
          echo $table_name . " exists<br>";
      }
  } 

  $insert_base_queries = array(
      "INSERT INTO `metadata` (`id`, `option`, `value`, `description`, `rule`) VALUES
      (1, 'opening_time', '10:00', 'The time of the first slot', 'Opening Time'),
      (2, 'closing_time', '19:30', 'The time of the last slot', 'Closing Time'),
      (3, 'booking_frequency', '30', 'The amount of slots per hour, expressed in minutes.', 'Booking Frequency'),
      (4, 'booking_slots_day', '20', 'The total number of slots avaliable in one day.', 'Booking Slots Per Day'),
      (5, 'business_name', 'NailsClub', 'The name of the business.', 'Business Name'),
      (6, 'business_slogan', 'is it a mad ting', 'The slogan of the business.', 'Business Slogan');
  ",
  "INSERT INTO `admin` (`username`, `password`) VALUES ('asdf', 'asdf');"
  );
  foreach ($insert_base_queries as $query) {
      $db->doQuery($query);
  }
}

?>

<form action="" method="post" autocomplete="off">
<input type="text" name="username" placeholder="Username"/>
<input type="password" name="password" placeholder="Password">
<input type="password" name="Password_again" placeholder="Password Again">
<button type="submit">Submit</button>
</form>
