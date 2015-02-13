<?php
     $title = 'Forgot Password?';
     session_start();
     include_once("includes/core.php");
     include_once("functions/encryption.php");
     include("functions/email.php");
     
     //show login
     if (isset($_POST['email'])){
       $query = "SELECT * FROM users WHERE email = :email";
       $query_params = array(
            ':email' => $_POST['email']
            );
       $db->DoQuery($query, $query_params);
       $userdetails = $db->fetchAll();
       if ($userdetails) {
          $code = encrypt(rand(99341, 1102400));
          $query = "UPDATE users SET forgot_code = :code WHERE email = :email";
          $query_params = array(
            ':code' => $code,
            ':email' => $_POST['email']
            );
          $db->DoQuery($query, $query_params);
          $extra = array(':code' => $code);
          email($_POST['email'], $userdetails[0]['username'], $userdetails[0]['forename'], "forgotten_password", $extra);
       }
       header('Location: confirmation.php?type=forgot');
       exit();
     }
     include('includes/header.php');
     ?>
<h1>Forgot your password?</h1>
You can reset your password by typing in the email associated with your account.

<?php if (isset($error)) { ?>
<div class="error"><?php echo $error; ?></div>
<?php } ?>
<form action="forgot.php" method="post" autocomplete="off">
<input type="text" name="email" placeholder="email" /><br>
<input type="submit" value="Next" id="submit"/>
</form>

</div>