<?php

namespace classes;

class SessionWrapper {
    public static function has($name) {
        return isset($_SESSION[$name]);
    }
    public static function get($name) {
        return $_SESSION[$name];
    }

    public static function set($name, $value) {
        return $_SESSION[$name] = $value;
    }

    public static function end($name) {
        if (self::has($name)) {
            unset($_SESSION[$name]);
        }
    }
}