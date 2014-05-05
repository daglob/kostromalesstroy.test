<?php
/**
 * Created by PhpStorm.
 * User: konev_d
 * Date: 14.01.14
 * Time: 12:11
 */


namespace Users;

use simpleMySQL;

class Users
{

    protected static $_instance;
    public $data;
    public $id;
    private $_user_tab = "users";
    private $_user_role_tab = "role";

    private function __construct()
    {
        $this->DB = new simpleMySQL(_DB_HOST_, _DB_USER_, _DB_PASS_, _DB_DB_);
        $this->installDB();
    }

    function installDB()
    {
        $query = <<<SQL
CREATE TABLE IF NOT EXISTS `$this->_user_tab` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(100) NOT NULL,
  `pass` VARCHAR(32) NOT NULL,
  `role` INT NOT NULL DEFAULT 0,
  `mail` VARCHAR(150) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `login_UNIQUE` (`login` ASC)) DEFAULT CHARACTER SET cp1251 COLLATE cp1251_general_ci;
SQL;
        $this->DB->bind_param($query);
        $this->DB->query();

        $query = <<<SQL
CREATE TABLE `user_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `activity` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) DEFAULT CHARACTER SET cp1251 COLLATE cp1251_general_ci;
SQL;
        $this->DB->bind_param($query);
        $this->DB->query();

        /**
         * Set default user width default Login/Password : Admin/Admin
         */
        $userLogin = 'Admin';
        $userPass = 'Admin';
        $userPass = md5($userPass);
        $query = <<<SQL
INSERT IGNORE INTO `$this->_user_tab` (`login`, `pass`, `role`) VALUES (
'$userLogin',
'$userPass',
1);
SQL;
        $this->DB->bind_param($query);
        $this->DB->query();

        $userLogin = 'framesi';
        $userPass = 'justyou';
        $userPass = md5($userPass);
        $query = <<<SQL
INSERT IGNORE INTO `$this->_user_tab` (`login`, `pass`, `role`) VALUES (
'$userLogin',
'$userPass',
0);
SQL;
        $this->DB->bind_param($query);
        $this->DB->query();

        $query = <<<SQL
CREATE TABLE `$this->_user_role_tab` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name_role` VARCHAR(150) NOT NULL,
  `description` TEXT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_role_UNIQUE` (`name_role` ASC))DEFAULT CHARACTER SET cp1251 COLLATE cp1251_general_ci;;
SQL;
        $this->DB->bind_param($query);
        $this->DB->query();

        /**
         * Set default role for Admin
         */
        $query = <<<SQL
INSERT IGNORE INTO `$this->_user_role_tab` (`name_role`, `description`) VALUES (
'Administrators',
'Administrator can more...'
  );
SQL;
        $this->DB->bind_param($query);
        $this->DB->query();
    }

    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    public function getUserById($id = false)
    {
        if (!$id || !is_numeric($id)) {
            return false;
        }
        $query = <<<SQL
SELECT * FROM `$this->_user_tab` WHERE `id` = $id
SQL;
        $this->DB->bind_param($query);
        $result = $this->DB->query();

        return empty($result) ? false : $result[0];
    }

    public function getUserByLogin($login = false)
    {
        if (!$login) {
            return false;
        }
        $query = <<<SQL
SELECT * FROM `$this->_user_tab` WHERE `login` = '$login'
SQL;
        $this->DB->bind_param($query);
        $result = $this->DB->query();

        return empty($result) ? false : $result[0];
    }

    public function getPassByLogin($login = false)
    {
        if (!$login) {
            return false;
        }
        $query = <<<SQL
SELECT `pass` FROM `$this->_user_tab` WHERE `login` = '$login'
SQL;
        $this->DB->bind_param($query);
        $result = $this->DB->query();

        return empty($result) ? false : $result[0];
    }

    public function lastVisit()
    {
//        $this->db
    }

    public function isAdmin($id)
    {
        if (!$id) {
            global $AUTH;
            if ($AUTH->isAuth()) {
                $uData = $this->getUserSessionData();
                $id = $uData["uid"];
                $query = <<<SQL
SELECT `role` FROM `$this->_user_tab` WHERE `id` = $id
SQL;
                $this->DB->bind_param($query);
                $result = $this->DB->query();
                $status = empty($result) ? false : $result[0];
                if ($status["role"] == 1) {
                    return true;
                }
            } else {
                return false;
            }
        }
        $query = <<<SQL
SELECT `role` FROM `$this->_user_tab` WHERE `id` = $id
SQL;
        $this->DB->bind_param($query);
        $result = $this->DB->query();
        $status = empty($result) ? false : $result[0];

        if ($status["role"] == 1) {
            return true;
        }

        return false;
    }

    private function getUserSessionData()
    {
        global $AUTH;
        if ($AUTH->isAuth()) {
            return unserialize($_SESSION["AUTH"]);
        }

        return false;
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

}