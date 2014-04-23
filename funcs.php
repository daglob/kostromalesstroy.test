<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 27.03.14
 * Time: 1:21
 */


/**
 * @param $arr
 */
function d($arr)
{
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}

/**
 * @param array $array
 * @param bool  $urlIsNow
 *
 * @return bool
 */
function constructMenu($array = array(), $urlIsNow = false)
{
    if (empty($array)) {
        return false;
    }
    if (!$urlIsNow) {
        $re = '/([\/a-z0-9_-]+)[\.php]?[\.html]?/is';
        preg_match($re, $_SERVER['REQUEST_URI'], $matches);
        if (!empty($matches[1])) {
            $urlIsNow = $matches[1];
        }
    }
    $strMenu = '';
    $strMenu .= "<ul>\n";
    foreach ($array as $menuBlock) {
        if (empty($menuBlock['url']) || empty($menuBlock['name'])) {
            continue;
        }
        $strMenu .=
            "<li" . ($urlIsNow == $menuBlock['url'] ? " class='active'" : '') . "><a href='" . $menuBlock['url'] .
            "'>" .
            $menuBlock['name'] . "</a>" . (!empty($menuBlock['sub']) ? constructMenu($menuBlock['sub']) : '') . "</li>";
    }
    $strMenu .= "</ul>\n";

    return $strMenu;
}


function checkInsertedUrl()
{
    if (isset($_GET['inserturl']) && $_GET['inserturl'] != '') {
        if (!is_file($_GET['inserturl'] . '.php')) {
            header("Location: /404.php");
        } else {
            header("Location: /" . $_GET['inserturl'] . ".php");
        }
    }
}