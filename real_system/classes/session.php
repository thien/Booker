<?php
require_once("database.php");   
require_once("user.php");   
require_once("functions.php");  
?>

<?php   
class Session{
    private $logged = false;
    public $user_id;

    function __construct(){
        session_start();
        if($this->is_logged()){
            redirect_to("index.php");
        } else {
            $message = "Try Again!";
        }
    }

    public function is_logged(){
        return $logged;
    }

    public function login($user){
        if($user){
            $this->user_id = $_SESSION["user_id"] = $user->id ;
            $this->logged = true ;
        }
    }

    public function logout(){
        unset($_SESSION["user_id"]);
        unset($this->user_id);
        redirect_to("login.php");
    }
}

?>