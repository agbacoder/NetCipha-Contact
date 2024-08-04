<?php

require "../vendor/autoload.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');


include "../core-classes/initialize.php";
include "../autoloader.php";


if (getRequest() !== false){

$rModal = new Modal();

$param = json_decode(file_get_contents("php://input"));

$all_headers = getallheaders();

try{

 

  if (isset($all_headers['Authorization']) && !empty($all_headers['Authorization'])){
  $jwt = $all_headers['Authorization'];
  $secretKey = NetciphaClient::getSecret();
  $headers = new stdClass();

  $decoded = JWT::decode($jwt, new Key($secretKey, 'HS256'), $headers);

  $user_id = $decoded->data->user_id;

  if (isset($user_id) && !empty($user_id)){
  

        $rModal->message_id = isset($_GET['message_id'])? $_GET['message_id'] : errorHandle('404', "No id found");
        
        if (!empty($rModal->message_id)){

        $rModal->readSingleMail();
       
            $msg_arr = array(
                'user_id' => $rModal->user_id,
                'post_number' => $rModal->message_id,
                'client_email' => $rModal->client_email,
                'client_name' => $rModal->client_name,
                'subject' => $rModal->subject,
                'messages' => $rModal->messages,
                'replies' => $rModal->replies,
                'time_sent' => $rModal->time_sent
      );
    
       print_r(json_encode($msg_arr));
    
    
    
    
} else {
    http_response_code(200);
    errorHandle('404', "No Messages Selected");
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


} else {
  http_response_code(405);
    echo getRequest();
}


?>