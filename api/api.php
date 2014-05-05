<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 30.04.14
 * Time: 0:20
 */
session_start();
use Users\Auth;
use Users\Users;

require_once "config.php";
require_once _CLASS_ROOT_."MySQL.php";
require_once _CLASS_ROOT_."Users.php";
require_once _CLASS_ROOT_."Auth.php";

$USER = Users::getInstance();
$AUTH = Auth::getInstance();
global $AUTH, $USER;

/**
 * for admin panel
 */
if ($_SERVER['REQUEST_METHOD'] == $_GET) {
    $mod = (isset($_GET['mod']) && !empty($_GET['mod'])) ? $_GET['mod'] : false;
    $func = (isset($_GET['func']) && !empty($_GET['func'])) ? $_GET['func'] : false;
}
if(!empty($mod)){
    $tMod = ucfirst(strtolower($mod));
    $tmpFileName = _CLASS_ROOT_ . $tMod . '.php';
    if (file_exists($tmpFileName)) {
        include_once $tmpFileName;
        $className = 'Api\mod' . $tMod;
        if (class_exists($className)) {
            $$tMod = new $className();
        }
    }
}