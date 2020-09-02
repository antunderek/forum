<?php

class SessionWrapper {
    public static function status($name) {
        return isset($_SESSION[$name]);
    }
    public static function get($name {
        return $_SESSION[$name];
    }
    public static function set($name, $value) {
        return $_SESSION[$name] = $value;
    }

    public static function end($name) {
        unset($_SESSION[$name]);
    }
}