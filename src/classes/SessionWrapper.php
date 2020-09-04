<?php

namespace classes;

class SessionWrapper {
    public static function has($name, $key=null) {
        return isset($_SESSION[$name]) || isset($_SESSION[$name][$key]);
    }
    public static function get($name, $key=null) {
        if (isset($key)) {
            return $_SESSION[$name][$key];
        }
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

    public static function destroy() {
        unset($_SESSION);
        session_destroy();
    }
}