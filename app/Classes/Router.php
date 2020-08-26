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
            throw new RouteNotFoundException('Route not found ' . $this->path);
        }

        if (!in_array($_SERVER['REQUEST_METHOD'], $this->methods[$this->path])) {
            throw new MethodNotAllowedException('Method is not allowed: ' . $_SERVER['REQUEST_METHOD']);
        }

        return $this->routes[$this->path];
    }
}