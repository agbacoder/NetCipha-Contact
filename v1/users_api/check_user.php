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



if (getRequest() !== false){
   
$modal = new UserModal();

   $data = json_decode(file_get_contents("php://input"));

   $check_data = $modal->loginCheck();

        $all_headers = getallheaders();

                try{

                    $jwt = $all_headers['Authorization'];
                    $secretKey = NetciphaClient::getSecret();
                    $headers = new stdClass();

                    $decoded = JWT::decode($jwt, new Key($secretKey, 'HS256'), $headers);

                    $user_id = $decoded->data->user_id;
                    echo $user_id;


                } catch (Exception $ex) {
                    http_response_code(403);
                    echo json_encode(array(
                        'code' => '403',
                        'message' => $ex->getMessage()
                    ));
                }
           
} else {
    http_response_code(405);
    errorHandle('405', 'Server Request Method Error');
}




?>