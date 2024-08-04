<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization');

include "../core-classes/initialize.php";
include "../autoloader.php";


if (putRequest() !== false){
   

$modal = new Modal();

$data = json_decode(file_get_contents('php://input'));


try{

    $jwt = $all_headers['Authorization'];
  
    if (isset($jwt) && !empty($jwt)){
  
    $secretKey = NetciphaClient::getSecret();
    $headers = new stdClass();
  
    $decoded = JWT::decode($jwt, new Key($secretKey, 'HS256'), $headers);
  
    $user_id = $decoded->data->user_id;
  
    if (isset($user_id) && !empty($user_id)){

        $data->message_id = isset($_GET['message_id'])? $_GET['message_id'] : errorHandle('404', "No id found");


    if (!empty($user_id) && !empty($data->message_id)&& !empty($data->replies)){
        $modal->replies = $data->replies;
        $modal->user_id = $user_id;
        $modal->message_id  = $data->message_id;
   
        
            if($modal->replyMail() == true) {
               errorHandle('200', "data updated succesfully"); 
             } else {
               errorHandle('504', "data unable to update"); 
            }
       

            } else {

                errorHandle('404', "All fields are required");
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
                echo putRequest();
        }




?>