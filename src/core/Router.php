<?php

namespace core;

use exceptions\MethodNotAllowedException;
use exceptions\RouteNotFoundException;

class Router {
    const CONTROLLERS_PATH = '/var/www/html/forum/src/controllers/';
    protected $path;
    protected $controller;
    protected $method;

    public function setPath($path = '/') {
        $this->path = $path;
    }

    public function findPath() {
        $temp = parse_url($this->path);
        $temp = explode('/', $temp['path']);
        if (count($temp) > 3) {
            throw new RouteNotFoundException('Route not found');
        }
        $this->controller = (isset($temp[1]) && $temp[1] !== '') ? ucfirst(strtolower(trim($temp[1])) . 'Controller') : 'HomeController';
        $this->method = (isset($temp[2]) && $temp[2] !== '') ? strtolower(trim($temp[2])) : 'index';
    }

    public function getPath() {
        $controllerpath = self::CONTROLLERS_PATH . $this->controller;
        $controllerfullpath = $controllerpath . '.php';
        if (!file_exists($controllerfullpath)) {
            throw new RouteNotFoundException('Route not found ' . $controllerfullpath);
        }
        $this->controller= '\\controllers\\' . $this->controller;
        if (!method_exists($this->controller, $this->method)) {
            throw new MethodNotAllowedException();
        }

        $path = array(
            'controller' => $this->controller,
            'method' => $this->method
        );
        return $path;
    }
}