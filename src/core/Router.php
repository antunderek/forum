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
        $urlParts = parse_url($this->path);
        $urlParts = explode('/', $urlParts['path']);

        if (!$this->validUserUrl($urlParts)) {
            //404
            throw new RouteNotFoundException('Route not found');
        }

        $this->removeTrailingSlashUrl($urlParts);

        $this->controller = (isset($urlParts[1]) && $urlParts[1] !== '') ? ucfirst(strtolower(trim($urlParts[1])) . 'Controller') : 'HomeController';
        $this->method = (isset($urlParts[2]) && $urlParts[2] !== '') ? strtolower(trim($urlParts[2])) : 'index';
    }

    private function removeTrailingSlashUrl($urlParts) {
        if (count($urlParts) < MAX_URL_SIZE && $urlParts[1] === '') {
            return;
        }

        if (substr($this->path, -1) === '/') {
            $fixedUrl = rtrim($_SERVER['REQUEST_URI'], '/');
            header("Location: $fixedUrl");
        }
    }

    private function validUserUrl($urlParts) {
        if (count($urlParts) > MAX_URL_SIZE) {
            return false;
        }

        if (isset($urlParts[1], $urlParts[2])) {
            if ($urlParts[1] === '' && $urlParts[2] !== '') {
                return false;
            }
        }

        return true;
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