<?php
class database {
  public function initiate() {
  if ($_SERVER['HTTP_HOST'] != "localhost") {
	$user             = "sql346641";
	$password         = "dY7%lG1%";
	$hostname         = "sql3.freemysqlhosting.net";
	$dbn              = "sql346641";
//	$user             = "thien_db";
//	$password         = "1a4face37a";
//	$hostname         = "projects.tnguyen.ch";
//	$dbn              = "thien_projects";
  } else {
	$user             = "thien";
	$password         = "JmuVnBrLxqAFTEhA";
	$hostname         = "localhost";
	$dbn              = "booking";
  }
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

  public function DoQuery($query, $query_params) {
    try
    {
      $this->result = $this->database->prepare($query);
      if ($query_params != null)
      {
        $this->result->execute($query_params);
      }
      else
      {
        $this->result->execute();
      }
    }
    catch(PDOException $e)
    {
      die();
    }
  }

  // A function to fetch a single row from the query
  public function fetch() {
    return $this->result->fetch();
  }
  public function fetchAssoc() {
    return $this->result->fetch(PDO::FETCH_ASSOC);
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
