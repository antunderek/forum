<?php

class Router {
    const CONTROLLERS_PATH = '/var/www/html/forum/app/Controllers/';
    protected $path;
    protected $routes = [];
    protected $methods = [];

    protected $controller;
    protected $method;

    public function setPath($path = '/') {
        $this->path = $path;
    }

    public function addRoute($uri, $handler, array $methods = ['GET']) {
        $this->routes[$uri] = $handler;
        $this->methods[$uri] = $methods;
    }

    public function getResponse() {
        if (!isset($this->routes[$this->path])) {
            throw new RouteNotFoundException('Route not found ' . $this->path);
        }

        if (!in_array($_SERVER['REQUEST_METHOD'], $this->methods[$this->path])) {
            throw new MethodNotAllowedException('Method is not allowed: ' . $_SERVER['REQUEST_METHOD']);
        }

        return $this->routes[$this->path];
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
            throw new RouteNotFoundException('Route not found ' . $this->path);
        }
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