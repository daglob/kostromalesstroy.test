<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 28.04.14
 * Time: 23:30
 */
include_once "authcontrol.php";
include_once "header.php";
?>
    <article>
        <?
        if ($mod) {
            include_once _API_ . "mod/" . $mod . '.php';
        }
        ?>
    </article>
<?
include_once "footer.php";
//}