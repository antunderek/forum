<?php

class CookieWrapper
{
    public static function status($id) {
        return isset($_COOKIE[$id]);
    }

    public static function set($id, $value, $expire)
    {
        setcookie($id, $value, time()+$expire);
    }

    public static function get($id) {
        return $_COOKIE[$id];
    }

    public static function destroy($id) {
        if (self::status($id)) {
            unset($_COOKIE[$id]);
            setcookie($id, "", time() - 3600, '/');
        }
    }
}