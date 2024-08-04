<?php


        function errorHandle($code, $message) {
        header('content-type: application/json');
        $err = (json_encode(['status'=>$code, 'message'=>$message]));
        echo $err;
        exit;
    
        }
        function message($code, $message) {
            header('content-type: application/json');
            $msg = (json_encode(['status'=>$code, 'message'=>$message]));
            echo $msg;
            exit;
        
        
        }

        function postRequest(){
        $req;
        if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
           
            $req = false;
        } else 
        {
            $req = true;
        }
         return $req;
        }

        function getRequest(){
            $req;
            if ($_SERVER['REQUEST_METHOD'] !== 'GET'){
                errorHandle('302', 'Server Request Error');
                $req = false;
            } else 
            {
                $req = true;
            }
             return $req;

            }
            function putRequest(){
                $req;
                if ($_SERVER['REQUEST_METHOD'] !== 'PUT'){
                    errorHandle('303', 'Server Request Error');
                    $req = false;
                } else 
                {
                    $req = true;
                }
                 return $req;
                }

                function delRequest(){
                    $req;
                    if ($_SERVER['REQUEST_METHOD'] !== 'DELETE'){
                        errorHandle('304', 'Server Request Error');
                        $req = false;
                    } else 
                    {
                        $req = true;
                    }
                     return $req;
                    }

                function userId( $length = 45){
                    $str = sha1(rand());
                    $rand_str = substr($str, 0 , $length);
                    return $rand_str;
                }
                function secretKey($user_id){
                    $key = hash_hmac("sha256", $user_id, 'secret key');
                    return $key;
                }
               
    
                


    

?>