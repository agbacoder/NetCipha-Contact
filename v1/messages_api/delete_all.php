<?php

require "../vendor/autoload.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization');

include "../core-classes/initialize.php";
include "../autoloader.php";


if (delRequest() !== false){

$modal = new Modal($dbh);

$data = json_decode(file_get_contents('php://input'));


$all_headers = getallheaders();

try{

        $jwt = $all_headers['Authorization'];

    if (isset($jwt) && !empty($jwt)){

        $secretKey = NetciphaClient::getSecret();
        $headers = new stdClass();

        $decoded = JWT::decode($jwt, new Key($secretKey, 'HS256'), $headers);

        $user_id = $decoded->data->user_id;
   
    if (isset($user_id) && !empty($user_id)){
        
            if($modal->deleteAllMail() == true) {
               errorHandle('200', "data deleted succesfully"); 
              } else {
               errorHandle('504', "data unable to delete"); 
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
    echo delRequest();
}




?>