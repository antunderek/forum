<?php

namespace classes;
use PDO;

class DatabaseInstance
{
    private static $db = null;

    private function __construct()
    {
        $config = include BP . 'config/dbconf.php';
        self::$db = new PDO(
            $config['db_driver'] . ':host=' . $config['db_host'] . ';dbname=' . $config['db_name'],
            $config['db_user'],
            $config['db_pass']
        );
    }

    public static function getDb() {
        if (self::$db === null) {
            return new DatabaseInstance;
        }
        return self::$db;
    }
}