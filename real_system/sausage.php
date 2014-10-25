<?php
include('includes/connection.php'); 
   
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
   
        $username = $_POST['username'];
        $password = $_POST['password'];
        $forename = $_POST['forename'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $phoneno = $_POST['phoneno'];
    
        if (empty($username) or empty($password)) {
            $error = 'All fields are required!';
        }   else {
        $query = $pdo->prepare('INSERT INTO client (username, password, forename, surname, email, phoneno, activated) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $query->bindValue(1, $username);
        $query->bindValue(2, $password);
        $query->bindValue(3, $forename);
        $query->bindValue(4, $surname);
        $query->bindValue(5, $email);
        $query->bindValue(6, $phoneno);
        $query->bindValue(7, '0');
        $query->execute();
        header('Location: confirmation.php');
        }
?>
<html>
<head>
<title>Register</title>
</head>
<body>
<?php if (isset($error)) { ?>
            <div class="error"><?php echo $error; ?></div>
            <?php }?>

<form method="post" action="register.php" autocomplete="on"> 
    <h1> Sign up </h1> 
    <p> 
         <label>First Name:</label>
         <input id="firstnamesignup" name="forename" required="required" type="text" placeholder="First" />
    </p>
    <p> 
         <label>Last Name:</label>
         <input id="lastnamesignup" name="surname" required="required" type="text" placeholder="Last" />
    </p>

<hr>

    <p> 
         <label>Username:</label>
         <input id="usernamesignup" name="username" required="required" type="text" placeholder="Username" />
    </p>
    <p> 
         <label>Password:</label>
         <input id="passwordsignup" name="password" required="required" type="password" placeholder="Password"/>
    </p>
    <p> 
         <label>Confirm Password:</label>
         <input id="passwordsignup_confirm" name="passwordsignup_confirm" required="required" type="password" placeholder="Password"/>
    </p>

    <hr>

    <p> 
         <label>Email:</label>
         <input id="emailsignup" name="email" required="required" type="email" placeholder="example@domain.com"/> 
    </p>
        <p> 
         <label>Email:</label>
         <input id="emailsignup_confirm" name="emailsignup_confirm" required="required" type="email" placeholder="example@domain.com"/> 
    </p>
            <p> 
         <label for="phoneno" class="phone" data-icon="n" >Phone Number:</label>
         <input id="phonenumber" name="phoneno" required="required" type="number" placeholder=""/> 
    </p>
    

    
    <p class="signin button"> 
    <input type="submit" value="Register"/> 
    </p>
</form>


</body>
</html>

