<?php

require_once('app/loader.php');
require_once('app/constants.php');

$app = new App;
$container = $app->getContainer();

$container['config'] = function () {
    return [
        'db_driver' => 'mysql',
        'db_host' => '127.0.0.1',
        'db_port' => '3306',
        'db_name' => 'forum',
        'db_user' => 'inchoo',
        'db_pass' => 'password',
    ];
};

$container['db'] = function ($c) {
    return new PDO(
        $c->config['db_driver'] . ':host=' . $c->config['db_host'] . ';dbname=' . $c->config['db_name'],
        $c->config['db_user'],
        $c->config['db_pass']
    );
};

$app->run();
