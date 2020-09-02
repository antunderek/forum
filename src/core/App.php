<?php

namespace core;

use classes\DatabaseInstance;
use core\Container;
use exceptions\RouteNotFoundException;
use exceptions\MethodNotAllowedException;

class App
{
    protected $container;

    public function __construct()
    {
        $this->container = new Container ([
            'router' => function () {
                return new Router;
            }
        ]);
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function run() {
        $router = $this->container->router;
        $router->setPath($_SERVER['REQUEST_URI'] ?? '/');

        try {
            $router->findPath();
            $response = $router->getPath();
        } catch (RouteNotFoundException $e) {
            echo "Route not found";
            die();
        } catch (MethodNotAllowedException $e) {
            echo "Method is not allowed";
            die();
        }

        return $this->process($response);
   }

   protected function process($callable) {
       $prep =  [new $callable['controller']($this->container->db), $callable['method']];
       return $prep();
   }
}