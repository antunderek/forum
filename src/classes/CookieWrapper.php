<?php

class CookieWrapper
{
    public static function status($id) {}

    public static function set($id, $value, $expire)
    {
    }

    public static function get($id) {
        return $_COOKIE[$id];
    }

    public static function destroy($id) {
        unset($_COOKIE[$id]);
    }
}