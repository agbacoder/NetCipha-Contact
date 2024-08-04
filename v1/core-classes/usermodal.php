<?php

class UserModal extends Connect{
    
    private $table = 'netcipha_users';


    public $user_id;
    public $name;
    public $email;
    public $password;
    public $conpassword;
    
   

    public function __construct() {
       
        parent::__construct();
    }

   
         

        

    public function emailChk(){
        $chk_query = ' SELECT email  FROM ' .$this->table. '  WHERE  email = ?';
        $this->connect();
        $chk_stmt = $this->conn->prepare($chk_query);

        $chk_stmt->bindParam(1, $this->email);

        $chk_stmt->execute();

        if ($chk_stmt->execute()){
                 
            $row = $chk_stmt->fetch(PDO::FETCH_ASSOC);

          
        }
        $this-> dbDisconnect();
        return $row;



    }

    public function createNewUser(){
        $in_query = "INSERT INTO {$this->table} (user_id, name, email, password)
        VALUES  (:user_id, :name, :email, :password)";
         $this->connect();
        $stmt2 = $this->conn->prepare($in_query);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->conpassword = htmlspecialchars(strip_tags($this->conpassword));
        


       
        $stmt2->bindParam(':user_id', $this->user_id);
        $stmt2->bindParam(':name', $this->name);
        $stmt2->bindParam(':email', $this->email);
        $stmt2->bindParam(':password', $this->password);
      

       
        $msg;
        if ($stmt2->execute()){
            $msg = true;
        } else {
            $msg = false;
        }
        $this-> dbDisconnect();

        return $msg;
        //         return true;
        //     }
        // } catch (Exception $e) {
        //     return false;
        //     errorHandle('101', "could not insert successfully");;
        // }
           

         }

         public function loginCheck(){
            $chk_query = ' SELECT user_id, email, name, password FROM ' .$this->table. '  WHERE  email = ?';
            $this->connect();
            $chk_stmt = $this->conn->prepare($chk_query);
    
            $chk_stmt->bindParam(1, $this->email);
            // $chk_stmt->bindParam(2, $this->password);

    
            $chk_stmt->execute();
    
            if ($chk_stmt->execute()){
                     
                $row = $chk_stmt->fetch(PDO::FETCH_ASSOC);
    
              
            }

            $this-> dbDisconnect();

            return $row;
    
    
    
        }

        }
         
         
?>