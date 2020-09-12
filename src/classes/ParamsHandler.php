<?php

namespace classes;

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

    public static function retreiveData() {
        return (new ParamsHandler)->typeMethod();
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
            return isset($data[$key][$name]);
        }
        return isset($data[$name]);
    }

    public static function getSafe($name, $key = null) {
        if (!self::has($name, $key)) {
            return;
        }
        $data = self::retreiveData();
        if (isset($key)) {
            if (is_string($data[$key][$name])) {
                return htmlspecialchars($data[$key][$name], ENT_QUOTES, 'UTF-8');
            }
            return $data[$key][$name];
        }
        if (is_string($data[$name])) {
            return htmlspecialchars($data[$name], ENT_QUOTES, 'UTF-8');
        }
        return $data[$name];
    }
}