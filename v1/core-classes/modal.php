<?php

class Modal extends Connect{
    private $table = 'messages';

    


    public $user_id;
    public $message_id;
    public $client_email;
    public $client_name;
    public $subject;
    public $messages;
    public $replies;
    public $time_sent;
    

    public function __construct() {
       
        parent::__construct();
    }

    public function readAllMail(){

        $net_query = 'SELECT 
                        u.user_id as user_id,
                        m.post_number,  
                        m.client_email,
                        m.client_name,
                        m.subject,
                        m.messages,
                        m.replies, 
                        m.time_sent
                        FROM 
                        '.$this->table.' m
                        LEFT JOIN 
                        api_users u ON m.user_id = u.user_id
                        WHERE u.user_id = (SELECT u.user_id FROM api_users u WHERE u.user_id = ?)
                        ORDER BY m.time_sent DESC';
        $this->connect();
        $stmt = $this->conn->prepare($net_query);
        $stmt->bindParam(1, $this->user_id);

        $stmt->execute();

        $msg_read;
        if ($stmt->execute()){
            $msg_read = true;
            $this-> dbDisconnect();
            return $stmt;
        } else {
            $msg_read = false;
        }
         

        

    }

    public function insert(){


        
        $in_query = 
        
        "INSERT INTO {$this->table} (user_id, client_email, client_name, subject, messages, replies)
        VALUES  (:user_id, :client_email,  :client_name, :subject, :messages,  :replies)";
        $this->connect();
        $stmt2 = $this->conn->prepare($in_query);

        $this->client_email = htmlspecialchars(strip_tags($this->client_email));
        $this->client_name = htmlspecialchars(strip_tags($this->client_name));
        $this->subject = htmlspecialchars(strip_tags($this->subject));
        $this->messages = htmlspecialchars(strip_tags($this->messages));
        $this->replies = htmlspecialchars(strip_tags($this->replies));

        $stmt2->bindParam(':user_id', $this->user_id);
        $stmt2->bindParam(':client_email', $this->client_email);
        $stmt2->bindParam(':client_name', $this->client_name);
        $stmt2->bindParam(':subject', $this->subject);
        $stmt2->bindParam(':messages', $this->messages);
        $stmt2->bindParam(':replies', $this->replies);

       
        $msg;
        if ($stmt2->execute()){
            $msg = true;
        } else {
            $msg = false;
        }
        $this-> dbDisconnect();
        return $msg;

        }


    public function readSingleMail(){

            $get_query = 'SELECT 
                            u.user_id as user_id,
                            m.post_number,
                            m.client_email,
                            m.client_name,
                            m.subject,
                            m.messages,
                            m.replies, 
                            m.time_sent
                            FROM 
                            '.$this->table.' m
                            LEFT JOIN 
                            api_users u ON m.user_id = u.user_id
                        WHERE  m.post_number = (SELECT   m.post_number FROM '.$this->table.' m WHERE  m.user_id = :user_id AND m.post_number = :post_number) LIMIT 1
                        ';
            $this->connect();
            $stmt3 = $this->conn->prepare($get_query);
            $stmt3->bindParam(1, $this->user_id);
            $stmt3->bindParam(2, $this->message_id);
    
            $stmt3->execute();

            $row = $stmt3->fetch(PDO::FETCH_ASSOC);
            
            $this->user_id = $row['user_id'];
            $this->message_id  = $row['post_number'];
            $this->client_email  = $row['client_email'];
            $this->client_name  = $row['client_name'];
            $this->subject = $row['subject'];
            $this->messages = $row['messages'];
            $this->replies = $row['replies'];
            $this->time_sent = $row['time_sent'];
    
            $this-> dbDisconnect();
        }


        public function replyMail(){
            $in_query2 = 'UPDATE  '.$this->table.' m
            SET m.replies = ?
            WHERE m.user_id = ? AND  m.message_id = ?
            ';
            $this->connect();

            $stmt4 = $this->conn->prepare($in_query2);
    
           
            $this->replies = htmlspecialchars(strip_tags($this->replies));
            $this->user_id = htmlspecialchars(strip_tags($this->user_id));
            $this->message_id = htmlspecialchars(strip_tags($this->message_id));

            $stmt4->bindParam(1, $this->replies);
            $stmt4->bindParam(2, $this->user_id);
            $stmt4->bindParam(3, $this->message_id);
           
            $msg;
            if ($stmt4->execute()){
                $msg = true;
            } else {
                $msg = false;
            }
            $this-> dbDisconnect();

            return $msg;
    
             }


        
    

        public function deleteSingleMail(){ 
                $this->connect();

                $del_query = 
                'DELETE FROM  '.$this->table.' 
                WHERE user_id = ? AND  message_id = ?
                ';
        
                $stmt5 = $this->conn->prepare($del_query);
        
               
                $this->user_id = htmlspecialchars(strip_tags($this->user_id));
                $this->message_id = htmlspecialchars(strip_tags($this->message_id));
    
                
                $stmt5->bindParam(1, $this->user_id);
                $stmt5->bindParam(2, $this->message_id);

                $msg;
                if ($stmt5->execute()){
                    $this-> dbDisconnect();

                    $msg = true;
                } else {
                    $msg = false;
                }
        
                return $msg;

            }
            public function deleteAllMail(){ 

                $del_query = 
                'DELETE FROM  '.$this->table.' 
                WHERE user_id = ? 
                ';
                $this->connect();

                $stmt5 = $this->conn->prepare($del_query);
        
               
                $this->user_id = htmlspecialchars(strip_tags($this->user_id));
    
                
                $stmt5->bindParam(1, $this->user_id);        
               
                
        
               
                $msg;
                if ($stmt5->execute()){
                    $msg = true;
                } else {
                    $msg = false;
                }
                $this-> dbDisconnect();

                return $msg;

            }

           
    
    



}
?>