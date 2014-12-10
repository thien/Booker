<?php 
$title = 'Edit';
include_once("includes/core.php");
include("functions/encryption.php");

$query = "SELECT * FROM users WHERE username = :username";
$query_params = array(
    ':username' => $_COOKIE['userdata']['username']
);
$db->DoQuery($query, $query_params);
$prevalue = $db->fetch();

if($_POST) {
$username = $_COOKIE['userdata']['username'];
$password = trim($_POST['new_password']);
$current_password = encrypt(trim($_POST['current_password']));
$password_confirm = trim($_POST['new_password_confirm']);
$forename = trim(ucfirst($_POST['forename']));
$surname = trim(ucfirst($_POST['surname']));
$email = trim($_POST['email']);
$phoneno = trim($_POST['phoneno']);
$errors = array();


// check if username is available
$query = ("SELECT username FROM users WHERE password = :currentpassword");
$query_params = array(
  ':currentpassword' => $current_password
  );
$db->DoQuery($query, $query_params);
$rows = $db->fetch();
if ($rows[0] !== $_COOKIE['userdata']['username']) {
   array_push($errors, "Your current password is incorrect, Please try again.");
}
  // Validate the input
  if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    array_push($errors, "Please specify a valid email address");

if (isset($password) & $password !== ""){
  if (strlen($password) < 5)
    array_push($errors, "Please enter a password. Passwords must contain at least 5 characters.");
}
  // If no errors were found, proceed with storing the user input
  if (count($errors) == 0) {
  $password = encrypt($password);
  $query = "UPDATE users SET (password, forename, surname, email, phoneno) VALUES (:password, :forename, :surname, :email, :phoneno) WHERE username = :username";
  $query_params = array(
  ':username' => $_COOKIE['userdata']['username'],
  ':password' => $password,
  ':forename' => $forename,
  ':surname' => $surname,
  ':email' => $email,
  ':phoneno' => $phoneno
  );
  $db->DoQuery($query, $query_params);
  header("Location: register/confirmation.php");        
  } else {
//	  $output = '';
//	  foreach($errors as $val) {
//	    $output .= "<p class='output'>$val</p>";
	 	foreach($errors as $val) {
	      echo "<p class='output'>".$val."</p>";
	  }
  }
  
}

include('includes/header.php');
?>





<script type="text/javascript" src="assets/jquery.js"></script>
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
$('#username_availability').load('functions/check_username.php').show();
$('#username_').keyup(function() {
  $.post('functions/check_username.php', { username: forms.username.value },
    function(result) {
      $('#username_availability').html(result).show();
    });
});    
});


// When the browser is ready...
$(function() {
  
    // Setup form validation on the #register-form element
    $("#forms").validate({
    
        // Specify the validation rules
        rules: {
            forename: "required",
            forename: "required",
            phoneno:  {
                required: true,
                minlength: 11,
                maxlength: 11
            },
            email: {
                required: true,
                email: true
            },
            username: "required",
            current_password: "required",
            password: {
                minlength: 6
            },
            email_confirm: {
                required: true,
                email: true,
                equalTo: "#email"
            },
            password_confirm: {
                equalTo: "#password"
            }
        },
        
        // Specify the validation error messages
        messages: {
            forename: "Please enter your forename.",
            surname: "Please enter your surname.",
            email: "Please enter a valid email address.",
            username: "Please enter a valid username.",
            current_password: {
                required: "Please provide a password."
                },
        password_confirm: {
            equalTo: "Please provide a password."
            },
            phoneno: {
                required: "Please provide a phone number.",
                minlength: "This phone number is invalid.",
                maxlength: "This phone number is invalid."
            }
        },
        
        submitHandler: function(form) {
            form.submit();
        }
    });

  });
  

</script>

<script type="text/javascript" src="assets/password_meter.js"></script>


<h1>Your Details.</h1><form method="post" action="<?PHP echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="on" id="forms"> 
  <div class="group">
  <div class="left">
    <label>Forename:</label><br>
      <input name="forename" required="required" type="text" placeholder="First" value="<?php echo $prevalue['forename'];?>"/>
    </div>

  <div class="right">
      <label>Surname:</label><br>
      <input name="surname" required="required" type="text" placeholder="Last" value="<?php echo $prevalue['surname'];?>" />
</div>
</div>
<hr>
   
<div class="group">
  <div class="left">
    <label>Password:</label><br>
    <input name="new_password" type="password" id="password" placeholder="Password"/><br>
    <label>Confirm Password:</label><br>
    <input name="new_password_confirm" type="password" placeholder="Password"/>
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
    <input name="email" required="required" type="email" id="email" placeholder="example@domain.com" value="<?php echo $prevalue['email'];?>"/><br>
    <label for="phoneno" class="phone" data-icon="n" >Phone Number:</label><br>
    <input name="phoneno" required="required" maxlength="10" type="number" value="<?php echo $prevalue['phoneno'];?>" placeholder=""/> 
  </div>
  <div class="right">
  </div>
</div>
<div>
<hr>
<div class="group">
  <div class="left">
    <label>Enter your current password to confirm changes:</label><br>
    <input name="current_password" required="required" type="password" id="current_password" placeholder="Password"/>
  </div>
  </div>
  <hr>
<p class="signin button"> 
<input type="submit" id="next" value="Update"/> 
</p>
</form>

</div>

<?php include 'includes/footer.php';
?>