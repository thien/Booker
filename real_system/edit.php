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


// check if password is available
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

  // you should make a loop going through items in an array; look at array_push. 
  if (count($errors) == 0) {

      $password = encrypt($password);
      if ($password = "532fa54f4ce9af28bc9eb777cc8b70b28d361f9f"){
        $password = NULL;
      }

      if ($forename != $prevalue['forename']){
        // $newdetails["0"][] = $forename;
        $txt = "UPDATE users SET forename = '$forename' WHERE username = '$username'";
        $db->DoQuery($txt);
        // echo "updated forename";
      }
      if ($surname != $prevalue['surname']){
        // $newdetails["1"][] = $surname;
        $txt = "UPDATE users SET surname = '$forename' WHERE username = '$username'";
        $db->DoQuery($txt);
                // echo "updated surname";
      }
      if ($password !== NULL AND $password !== $prevalue['password']){
        // $newdetails["2"][] = $password;
        $txt = "UPDATE users SET password = '$forename' WHERE username = '$username'";
        $db->DoQuery($txt);
                // echo "updated password";
      }
      if ($email != $prevalue['email']){
        // $newdetails["3"][] = $email;
        $txt = "UPDATE users SET email = '$email' WHERE username = '$username'";
        $db->DoQuery($txt);
                // echo "updated email";
      }
      if ($phoneno != $prevalue['phoneno']){
        // $newdetails["4"][] = $phoneno;
        $txt = "UPDATE users SET phoneno = '$phoneno' WHERE username = '$username'";
        $db->DoQuery($txt);
                // echo "updated phoneno";
      }

      header("Location: confirmation.php?type=updated"); 

      // function switcharoo2($tag) {
      //   switch ($tag)
      //     {
      //       case (0):
      //           $txt = "UPDATE users SET forename = :value WHERE username = :username";
      //           break;
      //       case (1):
      //           $txt = "UPDATE users SET surname = :value WHERE username = :username";
      //           break;
      //       case (2):
      //           $txt = "UPDATE users SET password = :value WHERE username = :username";
      //           break;
      //       case (3):
      //           $txt = "UPDATE users SET email = :value WHERE username = :username";
      //           break;
      //       case (4):
      //           $txt = "UPDATE users SET phoneno = :value WHERE username = :username";
      //           break;
      //     }
      //    return $txt;
      // }

      //         for ($x = 0; $x <= 4; $x++) {
      //           if (isset($newdetails[$x][0])){
      //             echo switcharoo2($x);
      //             $query_params = array{
      //               ':value' => $newdetails[$x][0],
      //               ':username' => $username
      //             }
      //             // echo $query;
      //             // echo $query_params;
      //         }
      //         $db->DoQuery($query, $query_params);
      //       }


      // foreach($newdetails[] as $val){
      //   echo "<pre>";
      //   print_r($newdetails);
      //   echo "</pre>";
      // }
      // echo "<pre>";
      // foreach ($newdetails[$x] as $value) {
      //     print_r()." <br>";
      // }


      // for ($x = 0; $x <= 4; $x++) {
      //   if (isset($newdetails[$x][0])){
      //     // echo $newdetails[$x][0];

      //     $value = $newdetails[$x][0];
      //     // echo $value;
      //     // echo gettype($value);
      //     $type = switcharoo($x);
      //     // echo gettype($type);
      //     $query = "UPDATE users SET activation_code = '".mysql_real_escape_string($value)."'' WHERE username = bendover";
      //     echo $query;
      //     // $db->DoQuery($query);
           
      //   }
      // }


      // header("Location: confirmation.php"); 
      // echo "</pre>";

      // $tag = 3;

      // you should make a loop going through items in an array; look at array_push. 

  // $query = "UPDATE users 
  // SET password = :password, forename = :forename, surname = :surname, email = :email, phoneno = :phoneno WHERE username = :username";
  // $query_params = array(
  // ':password' => $password,
  // ':forename' => $forename,
  // ':surname' => $surname,
  // ':email' => $email,
  // ':phoneno' => $phoneno,
  // ':username' => $username
  // );
  // $db->DoQuery($query, $query_params);
  // header("Location: confirmation.php");        
  } else {
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