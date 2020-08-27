<?php

spl_autoload_register(function($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $file = BP . "/app/{$class}.php";
    if (file_exists($file)) {
        require_once($file);
    }
});