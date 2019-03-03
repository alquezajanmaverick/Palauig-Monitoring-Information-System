<?php
session_start();
if(!isset($_SESSION['ID'])){
    session_destroy();
    header("Location:/mmis/administrator");
}

define('ROOT_DIR', dirname(__FILE__));
define('ROOT_URL', substr($_SERVER['PHP_SELF'], 0, - (strlen($_SERVER['SCRIPT_FILENAME']) - strlen(ROOT_DIR))));
define('ROOT_IMPORT',"http://" . $_SERVER['SERVER_NAME'] ."/mmis");
define('SALT','AwesomeProgrammerFromZambales');
