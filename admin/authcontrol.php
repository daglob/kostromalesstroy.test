<?php
/**
 * Created by PhpStorm.
 * User: konev_d
 * Date: 04.04.14
 * Time: 10:36
 */
session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/api/api.php";

if (isset($_GET['out']) && $_GET['out'] == 'getoutofherenow') {
    $AUTH->logOut();
}

if (!$AUTH->isAuth() && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = trim($_POST['login']);
    $pass = trim($_POST['password']);
    if ($login && $pass && $AUTH->logIn($login, $pass)) {
        header("Location: /admin/");
    }
}

if (!$AUTH->isAuth()) {
    header("Location: /admin/phpruauth.php");
}