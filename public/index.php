<?php

use core\App;

require_once('../src/core/autoload.php');

$app = new App;
$container = $app->getContainer();


$container['config'] = function () {
    return include '../config/dbconf.php';
};

$container['db'] = function ($c) {
    return new PDO(
        $c->config['db_driver'] . ':host=' . $c->config['db_host'] . ';dbname=' . $c->config['db_name'],
        $c->config['db_user'],
        $c->config['db_pass']
    );
};

$app->run();
