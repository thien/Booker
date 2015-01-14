<?php
class database {
public function initiate() {
  include($_SERVER['DOCUMENT_ROOT'].'/includes/db.php');
    try {
      $this->database = new PDO("mysql:host={$hostname};dbname={$database_name}", $username, $password);
    } catch(PDOException $e) { 
      die($e->getMessage());
    }
    $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

public function DoQuery($query, $query_parameters = array()) {
    try {
      $this->result = $this->database->prepare($query);
      $this->result->execute($query_parameters);
    } catch(PDOException $e) {
      die($e->getMessage());
    }
}
    // function QuickQuery($query) {
    //     $this->result = $this->DoQuery($query);
    //     $fetch_value = $this->fetch();
    //     return $fetch_value[0];
    // }
  // public function QuickQuery($query) {   // Quick fetch, Shows single row
  //     $this->result = $this->DoQuery($query);
  //     $fetch_value = $this->fetch();
  //     return $fetch_value[0];
  // }
  public function fetch() {   // Shows single row
    return $this->result->fetch();
  }
  public function fetchAll() {  // Shows all associated rows (in array)
    return $this->result->fetchAll();
  }
  public function RowCount() {   // Count rows
    return $this->result->RowCount();
  }
}
?>
