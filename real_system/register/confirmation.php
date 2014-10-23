<?php
include('includes/connection.php'); 
   
        $username = $_POST['username'];
        $password = $_POST['password'];
        $forename = $_POST['forename'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $phoneno = $_POST['phoneno'];
    
        if (empty($username) or empty($password)) {
            $error = 'All fields are required!';
        }   else {
        $query = $pdo->prepare('INSERT INTO client (username, password, forename, surname, email, phoneno) VALUES (?, ?, ?, ?, ?, ?)');
        $query->bindValue(1, $username);
        $query->bindValue(2, $password);
        $query->bindValue(3, $forename);
        $query->bindValue(4, $surname);
        $query->bindValue(5, $email);
        $query->bindValue(6, $phoneno);
        $query->execute();
        header('Location: index.php');
        }

//             $query = "INSERT INTO client (username, password, forename, surname, email, phoneno) VALUES ('$_POST[username]', '$_POST[password]',  '$_POST[name]', '$_POST[forename]', '$_POST[surname]', '$_POST[email]', '$_POST[phoneno]')";

// if ($result = $mysqli->query($query)) {
//     printf("ye");
// }

//     function confirm() {    
//         echo "<div class='success'>Thank you for your booking.</div>";        
//     } // Close function  


?>

<html>
<head>
<title>Register</title>
</head>
<body>


Swag 
</body>
</html>
