<?php 

function errors($error) {
switch ($error) {
    case 'R0':
        $message = "Your Username is invalid.";
        break;
    case 'R1':
        $message = "The Username is already in use.";
        break;
    case 'R2':
        $message = "The Password is invalid.";
        break;  
    case 'R3':
        $message = "The Password is too short.";
        break;   
    case 'R4':
        $message = "The Password is not secure enough.";
        break;   
    case 'R5':
        $message = "The Passwords do not match.";
        break;  
    case 'R6':
        $message = "This is an invalid email.";
        break;           
    case 'R7':
        $message = "The Emails do not match.";
        break;  
    case 'R8':
        $message = "The Phone Number is invalid.";
        break;  
    case 'R9':
        $message = "All fields are required!";
        break;  

}
return $message;
error_log($message, 0);
}

?>