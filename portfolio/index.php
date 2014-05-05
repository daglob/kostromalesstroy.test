<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 25.04.14
 * Time: 0:26
 */

$arrJs = array(
    "/css/portfolio.css"
);
$arrCss = array(
    "/js/portfolio.js"
);

include_once "../header.php";
$catalog = $_GET['catalog'] ? $_GET['catalog'] : false;
$item = $_GET['item'] ? $_GET['item'] : false;
?>
    <div class="row portfolio">
        <?
        if ($item && $catalog) {
            include_once "leftmenu.php";
            include_once "item.php";
        } elseif (!$item && $catalog) {
            include_once "leftmenu.php";
            include_once "category.php";
        } else {
            include_once "categorylist.php";
        }
        ?>
    </div>
    <script type="text/javascript">
        $(function () {
            var caruselSlider = $('.carousel');
            if (caruselSlider.length > 0) {
                $('.carousel').carousel({
                    interval: 2000
                });
            }
        });
    </script>
<?
include_once "../footer.php";