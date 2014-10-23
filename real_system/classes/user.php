<?php
require_once("database.php");
require_once("session.php");

class User {

    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;

    public static function find_all(){
        global $db;
        $object = new self;         
        $query = "SELECT * FROM users";
        $result = $db->add_query($query);
        $object = array();
        while($found = $db->fetch_array($result)){
            $object[] = self::resolve_data($found);
        }
        return $object;
    }

    public static function find_by_id($id){
        global $db;
        $object = new self;
        $query = "SELECT * FROM users WHERE id={$id}";
        $result = $db->add_query($query);
        $found = $db->fetch_array($result);
        $object = self::resolve_data($found);
        return $object;
    }

    public static function auth(){
        global $db;
        global $session;
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);

        $query = "SELECT * FROM users 
                    WHERE username = '{$username}' AND password = '{$password}' LIMIT                            1";

        $result = $db->add_query($query);
        if($data = $db->fetch_array($result)){
            $obj = self::find_by_id($data["id"]);
            return $obj;
        } else {
            $message="user not found.";
        }
    }

    private static function resolve_data($arr){
       $object = new self;
       $object->id = $arr["id"];
       $object->username = $arr["username"];
       $object->password = $arr["password"];
       $object->first_name = $arr["first_name"];
       $object->last_name = $arr["last_name"];
       return $object;


    }

}



  ?>