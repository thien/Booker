<?php
   
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);


include_once("includes/common.php");
// $database = new database;
// $database->initiate();

$check = '0';
$username = $_POST['username'];
$password = $_POST['password'];
$password_confirm = $_POST['password_confirm'];
$forename = ucfirst($_POST['forename']);
$surname = ucfirst($_POST['surname']);
$email = $_POST['email'];
$email_confirm = $_POST['email_confirm'];
$phoneno = $_POST['phoneno'];


if (empty($username) or empty($password) or empty($email) or empty($forename) or empty($surname) or empty($phoneno)) {
$error = 'All fields are required!';
} else {
  $check += 1;
}
if ($password === $password_confirm) {
  $check += 1;
}
if ($email === $email_confirm) {
  $check += 1;
}


// isset($username, $password, $forename, $surname, $email, $phoneno)




if ($check == '10'){
  $query = " INSERT INTO client (username, password, forename, surname, email, phoneno, activated) VALUES (:username, :password, :forename, :surname, :email, :phoneno, :activated)";
  $query_params = array(
  ':username' => $username,
  ':password' => $password,
  ':forename' => $forename,
  ':surname' => $surname,
  ':email' => $email,
  ':phoneno' => $phoneno,
  ':activated' => '0'
  );
  $db->DoQuery($query, $query_params);
  header("Location: register/confirmation.php");        
}

include('includes/header.php');
?>
<script type="text/javascript" src="assets/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function() {
$('#wowson').load('functions/check_username.php').show();
$('#username_').keyup(function() {
  $.post('functions/check_username.php', { username: forms.username.value },
    function(result) {
      $('#wowson').html(result).show();
    });
});    
});
</script>

<script type="text/javascript" src="assets/password_meter.js"></script>


 <h1>Register</h1> 
<form method="post" action="<?PHP echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="on" id="forms"> 
  <div class="group">
  <div class="left">
    <label>Forename:</label><br>
      <input name="forename" required="required" type="text" placeholder="First" />
    </div>
  <div class="right">
      <label>Surname:</label><br>
      <input name="surname" required="required" type="text" placeholder="Last" />
</div>
</div>
<hr>
<div class="group">
<div class="left">
  <label>Username:</label><br>
  <input id="username_" name="username" required="required" type="text" placeholder="Username"/>
</div>
<div class="right">
<div id="wowson">
 </div>
     </div></div>
     <div id="hr_invisible"></div>
   
<div class="group">
  <div class="left">
    <label>Password:</label><br>
    <input name="password" required="required" type="password" id="password" placeholder="Password"/><br>
    <label>Confirm Password:</label><br>
    <input name="password_confirm" required="required" type="password" placeholder="Password"/>
</div>
  <div class="right">
   <label>Password Strength:</label><br>
   <span id="password_bar">
     <span id="password_strength">No Data</span>
   </span>
  </div>
</div>
<hr>
<div class="group">
  <div class="left">
    <label>Email:</label><br>
    <input name="email" required="required" type="email" placeholder="example@domain.com"/><br>
    <label>Confirm Email:</label><br>
    <input name="email_confirm" required="required" type="email" placeholder="example@domain.com"/> <br>
    <label for="phoneno" class="phone" data-icon="n" >Phone Number:</label><br>
    <input name="phoneno" required="required" maxlength="10" type="number" placeholder=""/> 
  </div>
  <div class="right">
  </div>
</div>
<hr>
<?php if (isset($error)) { ?>
  <div class="error"><?php echo $error; ?></div>
<?php }?>
<p class="signin button"> 
<input type="submit" <?php if ($check !== 10) {echo 'disabled="disabled" id="next_disabled" ';} else {echo 'id="next"';} ?> value="Next"/> 
</p>
</form>

</div>

<?


?>