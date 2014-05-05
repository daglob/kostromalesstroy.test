<?
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 28.04.14
 * Time: 23:47
 */
if ($AUTH->isAuth()) {





    function constructHeadMenu($arrayMenu = array(), $url = false, $sub = false)
    {
        if (empty($arrayMenu)) {
            return false;
        }
        global $mod, $func;

        $result = "<ul";

        if (!$sub) {
            $result .= ' class="nav navbar-nav"';
        } else {
            $result .= ' class="dropdown-menu"';
        }
        $result .= ">\n";
        foreach ($arrayMenu as $menuPoint) {
            if (!$menuPoint['name'] || !$menuPoint['url']) {
                continue;
            }

            $active = false;
            if ((isset($mod) && !empty($mod)) || (isset($func) && !empty($func))) {
                $active = !empty($mod) && $mod == $menuPoint['url'];
                if (!$active && (isset($func) && !empty($func))) {
                    $active = !empty($func) && $func == $menuPoint['url'];
                }
            }

            $urlLink = $url . $menuPoint['url'] . '/';

            $subResult = false;
            if (!empty($menuPoint['sub'])) {
                $subResult = constructHeadMenu($menuPoint['sub'], $urlLink, true);
            }

            $result .= '<li';
            if ($active) {
                $result .= ' class="active"';
            }
            $result .= '>';


            $result .= '<a title = ""';
            if ($subResult) {
                $result .= ' href="#"';
                $result .= ' class="dropdown-toggle" data-toggle="dropdown"';
            } else {
                $result .= ' href = "/admin/' . $urlLink . '"';
            }
            $result .= '> ' . $menuPoint['name'];
            if ($subResult) {
                $result .= '<b class="caret"></b>';
            }
            $result .= ' </a > ';
            $result .= $subResult;

            $result .= "</li>\n";
        }
        $result .= "</ul>\n";

        return $result;
    }

    ?>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <?= (isset($arrayMenu) && !empty($arrayMenu)) ? constructHeadMenu($arrayMenu) : ''; ?>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="?out=getoutofherenow">Выход</a></li>
        </ul>
    </div>
<?
}