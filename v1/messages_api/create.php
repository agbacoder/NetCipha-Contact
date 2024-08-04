<?php

require "../vendor/autoload.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization');

include "../core-classes/initialize.php";
include "../autoloader.php";



if (postRequest() !== false){

$modal = new Modal();

$data = json_decode(file_get_contents('php://input'));


$all_headers = getallheaders();

try{

    if (isset($all_headers['Authorization']) && !empty($all_headers['Authorization'])){

        $jwt = $all_headers['Authorization'];
        $secretKey = NetciphaClient::getSecret();
    $headers = new stdClass();

    $decoded = JWT::decode($jwt, new Key($secretKey, 'HS256'), $headers);

    $user_id = $decoded->data->user_id;
   
    if (isset($user_id) && !empty($user_id)){

    if (!empty($user_id) && !empty($data->client_email) && !empty($data->client_name) && !empty($data->subject) && !empty($data->messages) && !empty($data->replies)){
    
    if (filter_var($data->client_email, FILTER_VALIDATE_EMAIL)){
        $modal->user_id = $user_id;
        $modal->client_email  = $data->client_email;
        $modal->client_name  = $data->client_name;
        $modal->subject = $data->subject;
        $modal->messages = $data->messages;
        $modal->replies = $data->replies;
   
   
        
            if($modal->insert() == true) {
               errorHandle('201', "data created succesfully"); 
             } else {
               errorHandle('404', "data unable to create"); 
            }
        }   else {
            http_response_code(403);

            errorHandle('403', "incorrect email format, must include '@', follwed by '.' ");
        }
       

        } else {

                errorHandle('403', "All fields are required");
        }

    } else {
                errorHandle('401', "Invalid User Id");
    }
} else {
    http_response_code(403);
    errorHandle('403', "You Are Not Allowed To Access This Resource"); 
}


} catch (Exception $ex) {
http_response_code(403);
echo json_encode(array(
    'code' => '403',
    'message' => $ex->getMessage()
));
}


    // when request is not post

} else {
    http_response_code(405);
    errorHandle('405', 'Server Request Method Error');
}




?>