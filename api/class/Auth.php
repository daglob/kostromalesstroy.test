<?php
/**
 * Created by PhpStorm.
 * User: konev_d
 * Date: 14.01.14
 * Time: 16:59
 */

namespace Users;


class Auth extends Users
{

    protected static $_instance;
    protected static $sold;
    private $error = array();
    private $NO_LOGIN_ERR = "Вы не ввели логин!";
    private $NO_PASSWORD_ERR = "Вы не ввели пароль!";
    private $NO_CORRECT_PASSWORD_ERR = "Вы ввели не верный логин или пароль!";

    function __construct()
    {
        self::$sold = 'ksdu234ja31skdbffke';
    }

    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }
    public function addActive(){

    }

    public function logIn($login, $pass)
    {
        global $USER;
        if (!$login || !$pass) {

            !$login ? $this->setError($this->NO_LOGIN_ERR) : false;
            !$pass ? $this->setError($this->NO_PASSWORD_ERR) : false;
            return false;
        }

        $r_pass = $USER->getPassByLogin($login);
        if (md5($pass) == $r_pass['pass']) {
            $this->setAuth($login, $r_pass["id"], $r_pass['pass']);
            return true;
        } else {
            $this->setError($this->NO_CORRECT_PASSWORD_ERR);
            return false;
        }
    }

    private function setError($error_str = false)
    {
        if (!$error_str) {
            return false;
        }
        $this->error[] = $error_str;
    }

    private function  setAuth($login, $uid, $r_pass)
    {
        $data = array(
            "uid"   => $uid,
            "key"   => md5($login, $r_pass),
            "udate" => date("U"),
            "date"  => date("Y-m-d h:i:s")
        );

        $day = 7; // Количество дней жизни Cookies
        $data = serialize($data);
        setcookie("A", $data, time() + 60 * 60 * 24 * $day, 'vip', "." . 'test.www.framesirus.ru', false);
        $_SESSION["authentification_api"] = $data;
    }

    public function logOut()
    {
        session_start();
        unset($_SESSION['AUTH']);
        session_unset();
        session_destroy();
        $this->clearAuthData();
    }

    function __destruct()
    {
        $this->getError();
    }

    public function getError()
    {
        if (!empty($this->error)) {
            foreach ($this->error as $err) {
                echo "<pre>";
                print_r($err);
                echo "</pre>";
            }
        }
    }

    public function  isAuth()
    {
        /**
         * Проверяем сессию
         */
        if (
            isset($_SESSION["authentification_api"]) &&
            !empty($_SESSION["authentification_api"]) &&
            $_SESSION["authentification_api"] != ''
        ) {
            return true;
        }

        /**
         * Проверяем Cookies
         */
        if (
            isset($_COOKIE["A"]) &&
            !empty($_COOKIE["A"]) &&
            $_COOKIE["A"]['uid'] != ''
        ) {
            global $USER;
            $uid = $_COOKIE["A"]['uid'];
            $key = $_COOKIE["A"]['k'];
            $tmp_user = $USER->getUserById($uid);

            if ($key == md5($tmp_user . md5(self::$sold))) {
                return true;
            } else {
                $this->clearAuthData();
            }
        }
        return false;
    }

    private function clearAuthData()
    {
        setcookie("A", "none", time() - 3600, 'vip', 'test.www.framesirus.ru', false);
        session_unset();
    }
} 