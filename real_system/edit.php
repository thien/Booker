<?php 
$title = 'Edit';
include_once("includes/core.php");
include("functions/encryption.php");


$user_id = $_COOKIE['userdata']['user_id'];
$query = "SELECT * FROM users WHERE id = :id";
$query_params = array(
    ':id' => $_COOKIE['userdata']['user_id']
);
$db->DoQuery($query, $query_params);
$prevalue = $db->fetch();

if($_POST) {
// $username = $_COOKIE['userdata']['username'];
  $user_id = $_COOKIE['userdata']['user_id'];
$password = trim($_POST['new_password']);
$current_password = encrypt(trim($_POST['current_password']));
$password_confirm = trim($_POST['new_password_confirm']);
$forename = trim(ucfirst($_POST['forename']));
$surname = trim(ucfirst($_POST['surname']));
$email = trim($_POST['email']);
$phoneno = trim($_POST['phoneno']);
$errors = array();


// check if password is available
$query = ("SELECT id FROM users WHERE password = :currentpassword");
$query_params = array(
  ':currentpassword' => $current_password
  );
$db->DoQuery($query, $query_params);
$rows = $db->fetch();
if ($rows[0] !== $_COOKIE['userdata']['user_id']) {
   array_push($errors, "Your current password is incorrect, Please try again.");
}
  // Validate the input
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    array_push($errors, "Please specify a valid email address.");
  }
  
  $query = ("SELECT email FROM users WHERE email = :email");
  $query_params = array(':email' => $email);
  $db->DoQuery($query, $query_params);
  $rows = $db->fetch();
  if ($rows) {
	if (!$rows['email'] = $email){
	array_push($errors, "This email is already associated with an account. Please choose another email.");	
    }
  }

    if (!preg_match("/^(\+44\s?7\d{3}|\(?07\d{3}\)?)\s?\d{3}\s?\d{3}$/",$phoneno)){
    array_push($errors, "Please specify a valid phone number.");
  }

if (isset($password) & $password !== ""){
  if (strlen($password) < 5)
    array_push($errors, "Please enter a password. Passwords must contain at least 5 characters.");
}

  if (count($errors) == 0) {

      $password = encrypt($password);
      if ($password = "532fa54f4ce9af28bc9eb777cc8b70b28d361f9f"){
        $password = NULL;
      }

      if ($forename != $prevalue['forename']){
        // $newdetails["0"][] = $forename;
        $txt = "UPDATE users SET forename = '$forename' WHERE id = '$user_id'";
        $db->DoQuery($txt);
        // echo "updated forename";
      }
      if ($surname != $prevalue['surname']){
        // $newdetails["1"][] = $surname;
        $txt = "UPDATE users SET surname = '$forename' WHERE id = '$user_id'";
        $db->DoQuery($txt);
                // echo "updated surname";
      }
      if ($password !== NULL AND $password !== $prevalue['password']){
        // $newdetails["2"][] = $password;
        $txt = "UPDATE users SET password = '$forename' WHERE id = '$user_id'";
        $db->DoQuery($txt);
                // echo "updated password";
      }
      if ($email != $prevalue['email']){
        // $newdetails["3"][] = $email;
        $txt = "UPDATE users SET email = '$email' WHERE id = '$user_id'";
        $db->DoQuery($txt);
                // echo "updated email";
      }
      if ($phoneno != $prevalue['phoneno']){
        // $newdetails["4"][] = $phoneno;
        $txt = "UPDATE users SET phoneno = '$phoneno' WHERE id = '$user_id'";
        $db->DoQuery($txt);
                // echo "updated phoneno";
      }

      header("Location: confirmation.php?type=updated"); 
     
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
  <div id="group">
  <div id="left">
    <label>Forename:</label><br>
      <input name="forename" required="required" type="text" placeholder="First" value="<?php echo $prevalue['forename'];?>"/>
    </div>

  <div id="right">
      <label>Surname:</label><br>
      <input name="surname" required="required" type="text" placeholder="Last" value="<?php echo $prevalue['surname'];?>" />
</div>
</div>
<hr>
   
<div id="group">
  <div id="left">
    <label>Password:</label><br>
    <input name="new_password" type="password" id="password" placeholder="Password"/><br>
    <label>Confirm Password:</label><br>
    <input name="new_password_confirm" type="password" placeholder="Password"/>
</div>
  <div id="right">
   <label>Password Strength:</label><br>
   <span id="password_bar">
     <span id="password_str">No Data</span>
   </span>
  </div>
</div>
<hr>
<div id="group">
  <div id="left">
    <label>Email:</label><br>
    <input name="email" required="required" type="email" id="email" placeholder="example@domain.com" value="<?php echo $prevalue['email'];?>"/><br>
    <label for="phoneno" class="phone" data-icon="n" >Phone Number:</label><br>
    <input name="phoneno" required="required" maxlength="10" type="number" value="<?php echo $prevalue['phoneno'];?>" placeholder=""/> 
  </div>
  <div id="right">
  </div>
</div>
<div>
<hr>
<div id="group">
  <div id="left">
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
