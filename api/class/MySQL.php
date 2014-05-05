<?php

class simpleMySQL
{

    protected $adapter = NULL;
    protected $table = NULL;
    protected $columns = array();
    protected $sql = '';

    public function __construct($host = NULL, $user = NULL, $password = NULL, $database = NULL)
    {
        try {

            $this->adapter = mysql_connect($host, $user, $password);

            mysql_select_db($database, $this->adapter);

//			mysql_query('SET NAMES utf8', $this->adapter);
//			mysql_query('SET CHARACTER_SET_CLIENT  = utf8', $this->adapter);
//			mysql_query('SET CHARACTER_SET_RESULTS = utf8', $this->adapter);

            mysql_query('SET NAMES cp1251', $this->adapter);
            mysql_query('SET CHARACTER_SET_CLIENT  = cp1251', $this->adapter);
            mysql_query('SET CHARACTER_SET_RESULTS = cp1251', $this->adapter);

        } catch (Exception $e) {

        }
    }

    public function table($Table = NULL)
    {
        try {

            $this->_free_table();

            $sql = sprintf('SHOW COLUMNS FROM %s', mysql_real_escape_string($Table));

            $result = mysql_query($sql, $this->adapter);

            while ($record = mysql_fetch_assoc($result)) {
                $this->{$record['Field']} = NULL;
                $this->columns[] = $record['Field'];
            }

            mysql_free_result($result);

            $this->table = $Table;
            print_r($this);
            return array( $this->table => $this->columns );

        } catch (Exception $e) {

        }
    }

    public function find($order = NULL, $group = NULL, $limit = NULL)
    {
        try {
            if ($this->table != NULL) {

                $_where = '';
                $_order = '';
                $_group = '';
                $_limit = '';

                $sql = sprintf('SELECT * FROM %s ', mysql_real_escape_string($this->table));
                foreach ($this->columns as $items) {
                    if ($this->{$items} != NULL) {
                        if (is_numeric($this->{$items})) {
                            $_where .= $_where != '' ?
                                sprintf("AND {$items} = %s ", mysql_real_escape_string($this->{$items})) :
                                sprintf("{$items} = %s ", mysql_real_escape_string($this->{$items}));
                        } else {
                            $_where .= $_where != '' ?
                                sprintf("AND {$items} = '%s' ", mysql_real_escape_string($this->{$items})) :
                                sprintf("{$items} = '%s' ", mysql_real_escape_string($this->{$items}));
                        }
                    }
                }
                if ($_where != NULL) {
                    $_where = "WHERE {$_where}";
                }
                if ($order != NULL) {
                    $_order .= "ORDER BY {$order} ";
                }
                if ($group != NULL) {
                    $_group .= "GROUP BY {$group} ";
                }
                if ($limit != NULL) {
                    $_limit .= "LIMIT {$limit} ";
                }
                $sql .= "{$_where}{$_group}{$_order}{$_limit}";

                $result = mysql_query($sql, $this->adapter);

                $data = array();

                while ($record = mysql_fetch_assoc($result)) {
                    $data[] = $record;
                }

                mysql_free_result($result);

                $this->_clear();

                return $data;
            }
        } catch (Exception $e) {

        }
    }

    public function modify($where = array())
    {

        try {

            if ($this->table != NULL) {

                $_set = '';
                $_where = '';

                $sql = sprintf('UPDATE %s SET ', mysql_real_escape_string($this->table));

                foreach ($this->columns as $items) {
                    if ($this->{$items} != NULL) {
                        if (is_numeric($this->{$items})) {
                            $_set .= $_set != '' ?
                                sprintf(", {$items} = %s ", mysql_real_escape_string($this->{$items})) :
                                sprintf("{$items} = %s", mysql_real_escape_string($this->{$items}));
                        } else {
                            $_set .= $_set != '' ?
                                sprintf(", {$items} = '%s' ", mysql_real_escape_string($this->{$items})) :
                                sprintf("{$items} = '%s'", mysql_real_escape_string($this->{$items}));
                        }
                    }
                }

                foreach ($where as $key => $value) {
                    if (is_numeric($value)) {

                        $_where .= $_where != '' ?
                            sprintf("AND %s = %s ", mysql_real_escape_string($key), mysql_real_escape_string($value)) :
                            sprintf("%s = %s ", mysql_real_escape_string($key), mysql_real_escape_string($value));
                    } else {
                        $_where .= $_where != '' ?
                            sprintf("AND %s = '%s' ", mysql_real_escape_string($key), mysql_real_escape_string($value)) :
                            sprintf("%s = '%s' ", mysql_real_escape_string($key), mysql_real_escape_string($value));
                    }

                }

                if ($_set == '' || $_where == '') {
                    return false;
                }
                $sql .= "{$_set} {$_where}";

                $this->_clear();
                return mysql_query($sql, $this->adapter);
            }

        } catch (Exception $e) {

        }
    }

    public function insert()
    {
        try {
            if ($this->table != NULL) {

                $_column = '';
                $_value = '';

                $sql = sprintf('INSERT INTO %s ', mysql_real_escape_string($this->table));

                foreach ($this->columns as $items) {
                    if ($this->{$items} != NULL) {
                        if (is_numeric($this->{$items})) {
                            $_column .= $_column != '' ? sprintf(", %s", mysql_real_escape_string($items)) :
                                sprintf("%s", mysql_real_escape_string($items));
                            $_value .= $_value != '' ? sprintf(", %s", mysql_real_escape_string($this->{$items})) :
                                sprintf("%s", mysql_real_escape_string($this->{$items}));
                        } else {
                            $_column .= $_column != '' ? sprintf(", %s", mysql_real_escape_string($items)) :
                                sprintf("%s", mysql_real_escape_string($items));
                            $_value .= $_value != '' ? sprintf(", '%s'", mysql_real_escape_string($this->{$items})) :
                                sprintf("'%s'", mysql_real_escape_string($this->{$items}));
                        }
                    }
                }

                if ($_column == '' || $_value == '') {
                    return false;
                }

                $sql .= "({$_column}) VALUES ({$_value})";

                mysql_query($sql, $this->adapter);

                $primary_id = mysql_insert_id($this->adapter);

                $this->_clear();

                return $primary_id;

            }
        } catch (Exception $e) {

        }
    }

    public function delete()
    {
        try {
            if ($this->table != NULL) {

                $_where = '';

                $sql = sprintf('DELETE FROM %s ', mysql_real_escape_string($this->table));
                foreach ($this->columns as $items) {
                    if ($this->{$items} != NULL) {
                        if (is_numeric($this->{$items})) {
                            $_where .= $_where != '' ?
                                sprintf("AND {$items} = %s ", mysql_real_escape_string($this->{$items})) :
                                sprintf("{$items} = %s ", mysql_real_escape_string($this->{$items}));
                        } else {
                            $_where .= $_where != '' ?
                                sprintf("AND {$items} = '%s' ", mysql_real_escape_string($this->{$items})) :
                                sprintf("{$items} = '%s' ", mysql_real_escape_string($this->{$items}));
                        }
                    }
                }
                if ($_where != '') {
                    $_where = "WHERE {$_where}";
                }

                $sql .= "{$_where}";

                $this->_clear();

                return mysql_query($sql, $this->adapter);

            }
        } catch (Exception $e) {

        }
    }

    public function bind_param($sql = NULL, $params = array(), $delimiter = '?')
    {
        try {

            $_sql = '';

            $split = explode($delimiter, $sql);
            $count = count($params);
            if ((count($split) - 1) != $count) {
                return false;
            }
            for ($i = 0; $i < $count; $i++) {
                if (is_numeric($params[$i])) {
                    $_sql .= sprintf("%s%s", $split[$i], mysql_real_escape_string($params[$i]));
                } else {
                    $_sql .= sprintf("%s'%s'", $split[$i], mysql_real_escape_string($params[$i]));

                }
            }

            if ($i < count($split)) {
                $_sql .= $split[$i];
            }

            $this->sql = $_sql;
            return $_sql;

        } catch (Exception $e) {

        }
    }

    public function query()
    {
        try {

            if ($this->sql == '') {
                return false;
            }

            $mode = strtoupper(trim($this->sql));
            $data = array();

            if (substr($mode, 0, 6) == 'SELECT' || substr($mode, 0, 4) == 'SHOW') {
                $result = mysql_query($this->sql, $this->adapter);
                while ($record = mysql_fetch_assoc($result)) {
                    $data[] = $record;
                }
                mysql_free_result($result);
            } else {
                if (substr($mode, 0, 6) == 'INSERT') {
                    mysql_query($this->sql, $this->adapter);
                    $data = mysql_insert_id($this->adapter);
                } else {
                    $data = mysql_query($this->sql, $this->adapter);
                }
            }

            return $data;

        } catch (Exception $e) {

        }
    }

    protected function _free_table()
    {
        try {
            if (count($this->columns) == 0) {
                return false;
            }

            foreach ($this->columns as $items) {
                unset($this->{$items});
            }

            $this->columns = array();

            return true;
        } catch (Exception $e) {

        }
    }

    protected function _clear()
    {
        try {
            $this->sql = '';
            foreach ($this->columns as $items) {
                $this->{$items} = NULL;
            }
        } catch (Exception $e) {

        }
    }
}
