<?php

namespace classes;

class DatabaseInstance
{
    private static $instance = null;
    private $db;

    private function __construct()
    {
        $config = include BP . 'config/dbconf.php';
        $this->db = new PDO(
            $config['db_driver'] . ':host=' . $config['db_host'] . ';dbname=' . $config['db_name'],
            $config['db_user'],
            $config['db_pass']
        );
    }

    public static function getDb() {
        if (self::$instance === null) {
            self::$instance = new DatabaseInstance;
        }
        return self::$instance;
    }

    /*private function __clone() {}

    public function __get($name) {
        return $this->db->$name;
    }

    public function __set($name, $value) {
        return $this->db->$name = $value;
    }

    public function __call($method, $args) {
        return call_user_func(array($this->db, $method), $args);
    }*/
}