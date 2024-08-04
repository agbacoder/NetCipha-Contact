<?php
include ('core-classes/initialize.php');


$sec = 'erfwsgrssxbrhbdshee';
$key = hash_hmac("sha256", $sec, 'secret key');


echo $key;
?>