<?php

class NetciphaClient {

    private static $config;


    public function __construct($config = []){
         self::$config = array_merge([
            'application_name' => '',
            'client_id'        => '',
            'client_secret'    => '',
            'scopes'           => null,
            'secret_key'       => ''
         ], $config);

    }


    public function setSecret($secret_key){
        self::$config['secret_key'] = $secret_key;
    }

    public static function getSecret(){
        return self::$config['secret_key'];
    }

 
}

?>