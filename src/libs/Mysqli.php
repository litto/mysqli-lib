<?php

 class MySqli
 {
  
  private $dbUser;
  private $dbPass;
  private $dbName;
  private $dbHost;
  private $dbConnection;
  private $errorString;
  private $filter;  
  private $util;
  public static $instance;
  public $query;
  public $newCon;


function __construct(){
  
   $this->dbConnection = null;
   $this->filter  = true; 
   $this->newCon   = false;
  }
  
  
  function setNew(){
   $this->newCon = true;
  }
  function noFilter()
  {
   $this->filter = false;
  }
  /*
   * Setting Error Message on Db Operation
   * Input String Message
   * Called upon db operation
  */
  
  function setError($string)
  {
   $this->errorString = $string;
   //echo "MYSQL ERROR - ".$this->errorString;
  }
  
  /*
   * get Error Message after a db operation
   * Retrieves the current error Status
  */
  
  function getError()
  {
   return $this->errorString;
  }
  
  /*
   * Connect to Mysql Database using set up data
   * Set up data being hold on Constructor
   * Modify the constrct params for connection change
  */
  
function connect()
{
if(is_null($dbConnection)){
                require_once(CONST_BASEDIR.'/config.php') ;    
    $this->dbUser  = $config["databaseUser"];
    $this->dbPass  = $config["databasePass"];
    $this->dbName  = $config["databaseName"];
    $this->dbHost  = $config["databaseHost"];
    
 $dbConnection = new mysqli($this->dbHost,$this->dbUser,$this->dbPass,$this->dbName);
if($this->dbConnection->connect_error) {
echo 'Connection Error'.$conn->connect_error;
}
}
}

function getInstance(){
   return $this->dbConnection;
  }
  
  
  function close()
  {
   if($this->dbConnection){
    $this->dbConnection->close();

    $this->dbConnection = null;
   }else{
    $this->dbConnection = null;
   }
  } 


function fetchAll($query)
{
             include(CONST_BASEDIR.'/config.php') ;    
    $this->dbUser  = $config["databaseUser"];
    $this->dbPass  = $config["databasePass"];
    $this->dbName  = $config["databaseName"];
    $this->dbHost  = $config["databaseHost"];
    
$dbConnection = new mysqli($this->dbHost,$this->dbUser,$this->dbPass,$this->dbName);
$fileds  = array();
$resultSet = array();
$result=$dbConnection->query($query);
$arr = $result->fetch_all(MYSQLI_ASSOC);
return $arr;
}


function insert($options,$table)
  {
   include(CONST_BASEDIR.'/config.php') ;    
    $this->dbUser  = $config["databaseUser"];
    $this->dbPass  = $config["databasePass"];
    $this->dbName  = $config["databaseName"];
    $this->dbHost  = $config["databaseHost"];
    
         $dbConnection = new mysqli($this->dbHost,$this->dbUser,$this->dbPass,$this->dbName);
   $queryString = "";
   $p    = count($options);
   $start   = 0;
   $fieldString = null;
   $valueString = null;
   foreach($options as $key=>$val){
    $fieldString.=" `{$key}`";
    $vk=$dbConnection->real_escape_string($val);
    $valueString.=" '{$vk}' ";
    if($start<$p-1){
     $fieldString.=",";
     $valueString.=",";
    }
    $start++;
   }   
    $queryString = "INSERT INTO `{$table}` ({$fieldString}) VALUES ({$valueString}) ";
  
   //echo "db".$queryString;
   
    //$result = mysql_query($queryString) or $this->setError("Insert".mysql_error());
   
       $result = $dbConnection->query($queryString);
       //$last_inserted_id = $dbConnection->insert_id;

  }
  
function update($options,$table,$condition)
  {
   include(CONST_BASEDIR.'/config.php') ;    
    $this->dbUser  = $config["databaseUser"];
    $this->dbPass  = $config["databasePass"];
    $this->dbName  = $config["databaseName"];
    $this->dbHost  = $config["databaseHost"];
    
         $dbConnection = new mysqli($this->dbHost,$this->dbUser,$this->dbPass,$this->dbName);
   
   $queryString = "";
   $fieldString = "";   
   $p    = count($options);
   $start   = 0;
   foreach($options as $key=>$val){
   $vk=$dbConnection->real_escape_string($val);
            $fieldString.=" `{$key}`='{$vk}'";
    if($start<$p-1){
     $fieldString.=",";
    }
    $start++;
   }   
   $queryString = "UPDATE `{$table}` SET {$fieldString} ";
   if(!empty($condition)){
    $queryString.=" WHERE {$condition} ";
   }
   $this->query = $queryString;   
   $result = $dbConnection->query($queryString);


  }


function delete($table,$condition)
  {
   include(CONST_BASEDIR.'/config.php') ;    
    $this->dbUser  = $config["databaseUser"];
    $this->dbPass  = $config["databasePass"];
    $this->dbName  = $config["databaseName"];
    $this->dbHost  = $config["databaseHost"];
    
         $dbConnection = new mysqli($this->dbHost,$this->dbUser,$this->dbPass,$this->dbName);
   $queryString = "DELETE FROM `{$table}` ";
   if(!empty($condition)){
    $queryString.=" WHERE {$condition} ";
   }
   $result = $dbConnection->query($queryString);
      return true;
  
  }


function execute($query){
 include(CONST_BASEDIR.'/config.php') ;    
    $this->dbUser  = $config["databaseUser"];
    $this->dbPass  = $config["databasePass"];
    $this->dbName  = $config["databaseName"];
    $this->dbHost  = $config["databaseHost"];
       $dbConnection = new mysqli($this->dbHost,$this->dbUser,$this->dbPass,$this->dbName);
                $result = $dbConnection->query($queryString);
  

  }
    
  function addFilter($string){
   return addslashes($string); 
     
  }
  
  function removeFilter($string){   
    return stripslashes($string);   
  } 
  
  
  function escapeHtml($text){
   return strip_tags($text);
  }
  




}
?>
