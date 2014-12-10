<?php
class database {
  public function initiate() {

	 $user             = "thien_db";
	 $password         = "1a4face37a";
	 $hostname         = "localhost";
	 $dbn              = "thien_projects";


//    $user           = "root";
//  $password         = "root";
//  $hostname         = "localhost";
//  $dbn              = "thien_projects";
  
    try
    {
      $this->database = new PDO("mysql:host={$hostname};dbname={$dbn}", $user, $password);
    }
    catch(PDOException $e)
    { 
      $error = "I'm unable to connect to the database server.";
      die("Failed to connect to database: " . $e->getMessage());
    }
  
    $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

public function DoQuery($query, $query_params = array()) {
    try
    {
      $this->result = $this->database->prepare($query);
      $this->result->execute($query_params);
    }
    catch(PDOException $e)
    {
      die();
    }
}
public function DoQueryz($query, $query_params = array()) {
    try
    {
      $this->result = $this->database->prepare($query);
      $this->result->execute($query_params);
    }
    catch(PDOException $e)
    {
      die();
    }
}

//  public function DoQuery($query, $query_params) {
//    try
//    {
//      $this->result = $this->database->prepare($query);
//      if ($query_params != null)
//      {
//        $this->result->execute($query_params);
//      }
//      else
//      {
//        $this->result->execute();
//      }
//    }
//    catch(PDOException $e)
//    {
//      die();
//    }
//  }

  // A function to fetch a single row from the query
  public function fetch() {
    return $this->result->fetch();
  }
  public function fetchAssoc() {
    return $this->result->fetch(PDO::FETCH_ASSOC);
  }
    public function fetchNum() {
    return $this->result->fetch(PDO::FETCH_NUM);
  }
  // A function to fetch multiple rows from the query
  public function fetchAll() {
    return $this->result->fetchAll();
  }
    // A function to fetch number of rows from the query
  public function RowCount() {
    return $this->result->RowCount();
  }

  // A function to fetch customers from a query
  public function fetchCustomers() {
  return $this->result->fetchAll(PDO::FETCH_ASSOC);
  }
}
?>
