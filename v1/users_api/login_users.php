<?php


require "../vendor/autoload.php";

use Firebase\JWT\JWT;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization');

include "../core-classes/initialize.php";
include "../autoloader.php";



if (postRequest() !== false){
   
$modal = new UserModal();

   
        $data = json_decode(file_get_contents('php://input'));


            if (!empty($data->email) && !empty($data->password)){

                if (filter_var($data->email, FILTER_VALIDATE_EMAIL)){

                    $modal->email = $data->email; 
                    
                    $check_data = $modal->loginCheck();

                    if ($check_data) {
                            $user_id = $check_data['user_id'];
                            $name = $check_data['name'];
                            $email = $check_data['email'];
                            $password = $check_data['password'];
                       
    
                        if(password_verify($data->password, $password)) {

                            $issuer = 'localhost';
                            $issued_at = time();
                            $not_before = $issued_at + 10;
                            $expiry = $issued_at + 1000;
                            $audience = 'myclients';
                            $user_data = array(
                                "user_id" => $check_data['user_id'],
                                "name" => $check_data['name'],
                                "email" => $check_data['email']

                            );

                            $payload_info = array(
                                "iss"    => $issuer,
                                "iss_at" => $issued_at,
                                "nbf"    => $not_before,
                                "exp"    => $expiry,
                                "aud"    => $audience,
                                "data"   => $user_data   
                            );
                            $secret_key = NetciphaClient::getSecret();

                            $jwt = JWT::encode($payload_info, $secret_key, 'HS256');
                            echo json_encode(array($jwt, $secret_key));
                            

                            http_response_code(200);
                            message('200', "logged in successfully");
                            
                         

                               
           
                         } else {
                           http_response_code(403);
                           errorHandle('403', "Incorrect password");
                         }        
                    
                    } else {
                        http_response_code(403);
                        errorHandle('403', "Not registered");
                    }



                         
                      

                    } else {
                        http_response_code(403);
                        errorHandle('403', "incorrect email format, must include '@', follwed by '.' ");
                    }

              

           


            } else {
                http_response_code(403);
                errorHandle('403', "All fields are required");

            }

      
    // when request is not post

} else {
    http_response_code(405);
    errorHandle('405', 'Server Request Method Error');
}




?>