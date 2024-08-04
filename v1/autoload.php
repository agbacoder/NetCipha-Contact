<?php



spl_autoload_register('fileAutoload');
function fileAutoload($classes) {
$url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if (strpos($url, 'api')!== false){
    $path = '../core-classes/';
} 
else {
    $path = 'core-classes/';
}

   
    $extension = '.php';
    $filepath = $path .$classes . $extension;

        if (!file_exists($filepath)) {
            return false;
        
    }

   
       

    include $filepath;
}


   

?> 