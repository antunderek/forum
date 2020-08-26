<?php

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

    public function get($uri, $handler) {
        $this->container->router->addRoute($uri, $handler, ['GET']);
    }

    public function post($uri, $handler) {
        $this->container->router->addRoute($uri, $handler, ['POST']);
    }

    public function map($uri, $handler, $methods) {
        $this->container->router->addRoute($uri, $handler, $methods);
    }

    public function run() {
        $router = $this->container->router;
        $router->setPath($_SERVER['PATH_INFO'] ?? '/');

        try {
            $response = $router->getResponse();
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
        /*if (is_array($callable[0])) {
            if (!is_object($callable[0])) {
                $callable[0] = new $callable[0];
            }
            return call_user_func($callable);
        }*/
        return $callable();
   }
}