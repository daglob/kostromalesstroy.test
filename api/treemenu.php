<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 05.05.14
 * Time: 22:27
 */
$arrayMenu = array(

    /*        array(
                "name" => '',
                "url" => '',
                "class" => '',
                "sub" => array()
            ),*/

    array(
        "name"  => 'Статичные страницы',
        "url"   => 'pages',
        "class" => '',
        "sub"   => array(
            array(
                "name"  => 'Список',
                "url"   => 'list',
                "class" => '',
                "sub"   => array()
            ),
            array(
                "name"  => 'Добавить страницу',
                "url"   => 'add',
                "class" => '',
                "sub"   => array()
            )
        )
    ),
    array(
        "name"  => 'Портфолио',
        "url"   => 'portfolio',
        "class" => '',
        "sub"   => array(
            array(
                "name"  => 'Категории',
                "url"   => 'portfolio',
                "class" => '',
                "sub"   => array()
            ),
            array(
                "name"  => 'Работы',
                "url"   => 'portfolio',
                "class" => '',
                "sub"   => array()
            ),
        )
    ),
    array(
        "name"  => '',
        "url"   => '',
        "class" => '',
        "sub"   => array()
    ),
);