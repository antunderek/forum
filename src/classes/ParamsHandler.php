<?php

namespace classes;

require_once BP . 'vendor/ezyang/htmlpurifier/library/HTMLPurifier.auto.php';

class ParamsHandler {

    private function typeMethod() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return $_GET;
        }
        elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $_POST;
        }
        return null;
    }

    private function purifyData($params) {
        $config = \HTMLPurifier_Config::createDefault();
        $purifier = new \HTMLPurifier($config);
        return $purifier->purifyArray($params);
    }

    public static function retreiveData() {
        $obj = new ParamsHandler();
        $params = $obj->typeMethod();
        return $obj->purifyData($params);
    }

    public static function get($name, $key = null) {
        if (!self::has($name, $key)) {
            return;
        }
        $data = self::retreiveData();
        if (isset($key)) {
            return $data[$key][$name];
        }
        return $data[$name];
    }

    public static function has($name, $key = null) {
        $data = self::retreiveData();
        if (isset($key)) {
            //return isset($data[$key][$name]);
            return !empty($data[$key][$name]);
        }
        //return isset($data[$name]);
        return !empty($data[$name]);
    }

    public static function unset($name, $key = null) {
        if (self::has($name, $key)) {
            $data = self::retreiveData();
        }
        if (isset($key)) {
            unset($data[$key][$name]);
        }
        else {
            unset($data[$name]);
        }
    }
}