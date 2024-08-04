<?php

defined('DS')        ? null : define('DS', DIRECTORY_SEPARATOR);
defined('SITE_ROOT') ? null : define('SITE_ROOT', DS . 'xampp' . DS .'htdocs'. DS .'contact');
defined('INC_PATH')  ? null : define('INC_PATH', SITE_ROOT . DS . 'v1'. DS . 'includes');
defined('CORE_PATH') ? null : define('CORE_PATH', SITE_ROOT . DS . 'core-classes');
defined('DB_PATH')   ? null : define('DB_PATH', SITE_ROOT . DS . 'config');
defined('MAIN_PATH')  ? null : define('MAIN_PATH', SITE_ROOT . DS . 'v1');




// require(DB_PATH.DS."connect.php");
// require(CORE_PATH.DS."modal.php");
require(INC_PATH.DS."functions.php");
require(MAIN_PATH.DS."config.php");
// require(CORE_PATH.DS."values.php");
// require(CORE_PATH.DS."user_modal.php");



?>