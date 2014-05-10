<?

session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/api/api.php";
d($_SERVER);
if (isset($_GET['out']) && $_GET['out'] == 'getoutofherenow') {
    $AUTH->logOut();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = trim($_POST['login']);
    $pass = trim($_POST['password']);
    if ($AUTH->logIn($login, $pass)) {
        header("Location: /admin/");
    }
}
include_once "header.php";
?>
    <div id="loginForm">
        <div class="row">
            <div class="col-lg-12 col-md-12">

                <form action="" role="form" class="form-horizontal" method="post" enctype="multipart/form-data">
                    <fieldset>
                        <legend>Войдите в административную панель:</legend>
                        <div class="form-group">
                            <div class="col-lg-8 col-md-8 col-lg-offset-2">
                                <input type="text" name="login" placeholder="Логин" class="form-control"
                                       autocomplete="off"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-2">
                                <input type="password" name="password" placeholder="Пароль" class="form-control"
                                       autocomplete="off"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-2">
                                <input type="submit" class="btn btn-default form-control" value="Вход"/>
                            </div>
                        </div>
                    </fieldset>
                </form>

            </div>
        </div>
    </div>
<?
include_once "footer.php";