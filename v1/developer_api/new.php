<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization');

include "../core-classes/initialize.php";
include "../autoloader.php";



if (postRequest() !== false){
   

$modal = new DeveloperModal();



   

   
        $data = json_decode(file_get_contents('php://input'));


            if (!empty($data->name) && !empty($data->email) && !empty($data->password) && !empty($data->conpassword)){

                if (filter_var($data->email, FILTER_VALIDATE_EMAIL)){

                   

                   
                    $modal->name  = $data->name;
                    $modal->email  = $data->email;
                    $modal->password  = password_hash($data->password, PASSWORD_DEFAULT);
                    $modal->conpassword = password_verify($data->conpassword, $modal->password);


                    
                    if ($modal->conpassword){

                        $result = $modal->emailChk();
    
                        if(!$result) {
               
                            $modal->user_id = userId();
                             if ($modal->user_id){

                                $secret_key = secretKey($modal->user_id);
                                if($modal->regNewClient() == true) {
                                    errorHandle('201',$secret_key);
                                  } else {
                                    errorHandle('404', "data unable to create"); 
                                 }
                             }else {
                                http_response_code(403);
                                errorHandle('403', "Something went wrong");
                             }

                               
           
                   } else {
                           http_response_code(403);
                           errorHandle('403', "Email already registered");
           
                   }
                    
                    } else {
                        http_response_code(403);
                        errorHandle('403', "passwords do not match");
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