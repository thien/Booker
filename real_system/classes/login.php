<?php
require_once("../../includes/database.php");    
require_once("../../includes/user.php");    
require_once("../../includes/functions.php");
require_once("../../includes/session.php");
?>

<?php
if(isset($_POST["submit"])){
    $obj = User::auth();
    if($obj){
        $session->login($obj);
        redirect_to("index.php");
    } else {
        $message= "USER NOT FOUND.";
    }
    echo '<p id="message">';
    echo output_message($message); 
    echo "</p>";

}
?>

<html>
<head>
    <title>Hello</title>
    <link rel="stylesheet" href="stylesheets/main.css">     
</head>
<body>
    <header id="header">
        <h1>Welcome</h1>
    </header>
    <div id="main">
        <h3>Please Login</h3>
        <form action="login.php" method="post">
            <p><label for="username">Username :</label><input type="text" name="username" placeholder="Username"/></p>
            <p><label for="password">Password :</label><input type="text" name="password" placeholder="Password"/></p>  
            <input type="submit" value="Submit" name="submit" />
        </form>            

    </div>

</body>