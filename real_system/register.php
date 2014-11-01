<?php
include_once("includes/core.php");
include("functions/encryption.php");
require_once('assets/recaptcha.php');

if($_POST) {
$username = trim($_POST['username']);
$password = trim($_POST['password']);
$password_confirm = trim($_POST['password_confirm']);
$forename = trim(ucfirst($_POST['forename']));
$surname = trim(ucfirst($_POST['surname']));
$email = trim($_POST['email']);
$email_confirm = trim($_POST['email_confirm']);
$phoneno = trim($_POST['phoneno']);

$errors = array();


// check if username is available
$query = ("SELECT username FROM client WHERE username = :username");
$query_params = array(
  ':username' => $username
  );
$db->DoQuery($query, $query_params);
$rows = $db->fetch();
if ($rows) {
   array_push($errors, "This username is already chosen. Please choose another username.");
}
  // Validate the input
  // if (strlen($name) == 0)
  //   array_push($errors, "Please enter your name");

  // if (!(strcmp($gender, "Male") || strcmp($gender, "Female") || strcmp($gender, "Other"))) 
  //   array_push($errors, "Please specify your gender");
  
  // if (strlen($address) == 0) 
  //   array_push($errors, "Please specify your address");
    
  if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    array_push($errors, "Please specify a valid email address");

  if (filter_var($email, FILTER_VALIDATE_EMAIL) !== filter_var($email, FILTER_VALIDATE_EMAIL))
    array_push($errors, "The email addresses do not match");

  if (strlen($username) == 0)
    array_push($errors, "Please enter a valid username");
  // if (!$username_available == TRUE)
  //   array_push($errors, "This username is already chosen. Please choose another username.");
    
  if (strlen($password) < 5)
    array_push($errors, "Please enter a password. Passwords must contain at least 5 characters.");
    
if ($_POST["recaptcha_response_field"]) {
    $resp = recaptcha_check_answer ($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
    if (!$resp->is_valid) {
    # set the error code so that we can display it
    // $error = $resp->error;
     array_push($errors, "The captcha is incorrect.");
  }
}



  // If no errors were found, proceed with storing the user input
  if (count($errors) == 0) {
  $password = encrypt($password);
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

// isset($username, $password, $forename, $surname, $email, $phoneno)


  //Prepare errors for output
  $output = '';
  foreach($errors as $val) {
    $output .= "<p class='output'>$val</p>";
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
            password: {
                required: true,
                minlength: 6
            },
            email_confirm: {
                required: true,
                email: true,
                equalTo: "#email"
            },
            password_confirm: {
                required: true,
                equalTo: "#password"
            }
        },
        
        // Specify the validation error messages
        messages: {
            forename: "Please enter your forename.",
            surname: "Please enter your surname.",
            email: "Please enter a valid email address.",
            username: "Please enter a valid username.",
            password: {
                required: "Please provide a password.",
                minlength: "Your password must be at least six characters long."
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

<div id="username_availability"></div>

</div>
</div>
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
    <input name="email" required="required" type="email" id="email" placeholder="example@domain.com"/><br>
    <label>Confirm Email:</label><br>
    <input name="email_confirm" required="required" type="email" placeholder="example@domain.com"/> <br>
    <label for="phoneno" class="phone" data-icon="n" >Phone Number:</label><br>
    <input name="phoneno" required="required" maxlength="10" type="number" placeholder=""/> 
  </div>
  <div class="right">
  </div>
</div>
<div>
<hr>
<label>Captcha</label>
<div class="captcha">

<?php echo recaptcha_get_html($publickey, $error); 
?>
</div>
<hr>
<?php if (isset($error)) { ?>
  <div class="error"><?php echo $error; ?></div>

<?php }?>
  <?php if($_POST) {
  echo $output; 
}
   ?>
<p class="signin button"> 
<input type="submit" id="next" value="Next"/> 
</p>
</form>

</div>

<?php include 'includes/footer.php';
?>