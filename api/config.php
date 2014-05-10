<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 24.04.14
 * Time: 22:56
 */

ini_set('display_error', 1);
ini_set('error_reporting', 1);
error_reporting(E_ERROR);
date_default_timezone_set('Europe/Moscow');

/**
 * ToDo: see this IP address for complete configurations
 *
 * ip default local web server: 127.0.0.1
 */

$defaultIP = '127.0.0.1';

//define("_LOCALSERVER_", $_SERVER['SER']);


define("_DB_HOST_", 'localhost');
define("_DB_USER_", 'root');
define("_DB_PASS_", 'root');
define("_DB_DB_", 'kostromalesstroy');
define("_DB_PREFIX_", '');

define("_API_", $_SERVER['DOCUMENT_ROOT'] . '/api/');
define("_CLASS_ROOT_", _API_ . 'class/');

include_once _API_ . "functions.php";
include_once _API_ . "treemenu.php";