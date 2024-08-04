<?php

class EmailModal extends Connect{
    private $table = 'api_users';
    
    public $user_email;
    public $user_id;
    
   

    public function __construct() {
       
        parent::__construct();
    }

   
         

        

    public function emailChk(){
        $chk_query = ' SELECT user_id, user_email  FROM ' .$this->table. '  WHERE  user_email = ?';
        $this->connect();
        $chk_stmt = $this->conn->prepare($chk_query);

        $chk_stmt->bindParam(1, $this->user_email);

        $chk_stmt->execute();

        if ($chk_stmt->execute()){
                 
            $row = $chk_stmt->fetch(PDO::FETCH_ASSOC);

          
        }
        $this-> dbDisconnect();
        return $row;



    }

    public function createNewMail(){
        $in_query = "INSERT INTO {$this->table} (user_id, user_email)
        VALUES  (:user_id, :user_email
        )";
            $this->connect();
        $stmt2 = $this->conn->prepare($in_query);

        $this->user_email = htmlspecialchars(strip_tags($this->user_email));

       
        $stmt2->bindParam(':user_id', $this->user_id);
        $stmt2->bindParam(':user_email', $this->user_email);
      

       
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

       
        }
         
         
?>