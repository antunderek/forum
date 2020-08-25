<?php

class Router {
    protected $path;
    protected $routes = [];
    protected $methods = [];

    public function setPath($path = '/') {
        $this->path = $path;
    }

    public function addRoute($uri, $handler, array $methods = ['GET']) {
        $this->routes[$uri] = $handler;
        $this->methods[$uri] = $methods;
    }

    public function getResponse() {
        if (!isset($this->routes[$this->path])) {
            die("Route not found");
        }

        if (!in_array($_SERVER['REQUEST_METHOD'], $this->methods[$this->path])) {
            die('Method not allowed');
        }

        return $this->routes[$this->path];
    }
}