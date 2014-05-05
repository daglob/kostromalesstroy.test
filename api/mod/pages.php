<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 05.05.14
 * Time: 22:29
 */
if ($func) {
    switch ($func) {
        case 'list':
            break;
        case 'add':
            $Pages->getList();
            break;
        default:
            echo "test";
            break;
    }
}
?>
<form action="">
    <input type="text"/>
    <input type="submit" value="Ok"/>
</form>
