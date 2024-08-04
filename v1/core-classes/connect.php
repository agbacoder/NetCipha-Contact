<?php

class Connect {
    private $dbname;
    private $host;
    private $user;
    private $pass;

    protected $conn;
   
    protected function __construct() {
       
           $this->host = 'localhost';
           $this->dbname = 'netcipha_contact';
           $this->user = 'root';
           $this->pass = '';
           
    } 
    protected function connect () {

        try {
            $this->conn = new PDO ("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->conn->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return  $this->conn;
          

           
        } 
       
        catch (PDOException $e){
            http_response_code(504);
            errorHandle('504', "internal server error");
        }
        catch (Exception $e){
            http_response_code(504);
            errorHandle('500', "internal server error");

        }

       

        
       
    
}

protected function dbDisconnect(){
    $this->conn = null;
}
   
}




?>