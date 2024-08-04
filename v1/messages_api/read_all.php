<?php

require "../vendor/autoload.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');


include "../core-classes/initialize.php";
include "../autoloader.php";



    


    try{
         $req = getRequest();
        if ($req !== false){
   
   
        $rModal = new Modal();

        
        $all_headers = getallheaders();

        try{

        $jwt = $all_headers['Authorization'];

        if (isset($jwt) && !empty($jwt)){

        $secretKey = NetciphaClient::getSecret();
        $headers = new stdClass();

        $decoded = JWT::decode($jwt, new Key($secretKey, 'HS256'), $headers);

        $user_id = $decoded->data->user_id;
   
        if (isset($user_id) && !empty($user_id)){
        
        $result = $rModal->readAllMail();

        $num = $result->rowCount();

            if ($num > 0){
                $msg_arr = array();
                $msg_arr['data'] = array();
                while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    $msg_items     = array( 
                    'user_id'      => $user_id,
                    'post_number'   => $message_id,
                    'client_email' => $client_email,
                    'client_name'  => $client_name,
                    'subject'      => $subject,
                    'messages'     => $messages,
                    'replies'      => $replies,
                    'time_sent'    => $time_sent
           
                );
                array_push($msg_arr['data'], $msg_items);
            }
                echo json_encode($msg_arr);

            } else{
                echo json_encode(array('message' =>'No messages found'));
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
                throw new errorException();
        }

    } 
    catch (errorException $ex){
        http_response_code(403);
        echo json_encode(array(
        'code' => '403',
        'message' => $ex->getMessage()
        ));
    }

   

?>