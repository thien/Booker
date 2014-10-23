  <?php

class Database{
    private $connection ;

    function __construct(){
        $this->open_connection();
    }

    public function open_connection(){
        $this->connection = mysql_connect("localhost" , "root" , "smokn");
        if(!$this->connection){
            die("Error while opening connection: " . mysql_error() );
        } else {
            $db_select = mysql_select_db("photo_gallery" , $this->connection);
            if(!$db_select){
                die("Error while selecting DB: " . mysql_error() );
            }
        }
    }

    public function close_connection(){
        if(isset($this->connection)){
            mysql_close($this->connection);
            unset($this->connection);
        }
    }

    public function add_query($query){
        $result = mysql_query($query , $this->connection);
        if(!$result){
            die("Error while adding query: " . mysql_error());
        } else { 
            return $result;
        }
    }

    public function fetch_array($result){
        return mysql_fetch_array($result);
    }

    public function escape_value ($value){          
        $value = mysql_real_escape_string($value);
        return $value;
    }

    public function num_rows ($result){
        return mysql_num_rows($result);
    }

    public function inserted_id(){
        return mysql_insert_id($this->connection);
    }

    public function affected_rows(){
        return mysql_affected_rows($this->connection);
    }

}

$db = new Database();

    ?>