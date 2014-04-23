<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 26.03.14
 * Time: 23:45
 */

require_once "app.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="windows-1251">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="/css/reset.css" type="text/css"/>
    <link rel="stylesheet" href="/css/bootstrap.min.css" type="text/css"/>
    <link rel="stylesheet" href="/css/bootstrap-theme.min.css" type="text/css"/>
        <link rel="stylesheet" href="/css/main.css" type="text/css"/>
    <link rel="stylesheet" href="/css/index.css" type="text/css"/>
    <link rel="stylesheet" href="/css/scrollbar.css" type="text/css"/>
    <script type="text/javascript" src="/js/jquery-2.1.0.js"></script>
    <script type="text/javascript" src="/js/jquery.scrollbar.min.js"></script>
</head>
<body>
<div class="bodycontainer">
    <div class="documentcontainer">
        <div class="header">
            <div class="mainmenu">
                <a class="navbar-brand" href="/">
                    <img src="/img/theme/Logo.png" alt="Архитектурно-строительная мастерская Окуневых" width="224"
                         height="34"/>
                </a>
                <?= constructMenu($mainmenu) ?>
            </div>
            <div class="nav navbar-nav navbar-right informblock">
                <div class="phone"><a href="tel:+79106615184">+7 910 661 51 84</a></div>
                <div class="phone"><a href="tel:+79109217698">+7 910 921 76 98</a></div>
            </div>
        </div>
        <div class="content">