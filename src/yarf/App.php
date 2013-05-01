<?php

namespace yarf;

class App
{
    private $router;

    function __construct()
    {
        $this->router = new Router();

        // inject controller and model autoloaders
        spl_autoload_register(function($className) {
            if(!file_exists(__DIR__ . '/../controllers/' . $className . '.php')) {
                return false;
            } else {
                require_once __DIR__ . '/../controllers/' . $className . '.php';
                return true;
            }
        });

        spl_autoload_register(function($className) {
            if(!file_exists(__DIR__ . '/../models/' . $className . '.php')) {
                return false;
            } else {
                require_once __DIR__ . '/../models/' . $className . '.php';
                return true;
            }
        });
    }

    public function __call($name, array $args)
    {
        if(in_array($name, array("get", "put", "post", "delete"))) {
            return $this->router->addRoute($args[0], array($name));
        } else if ($name == "match") {
            return $this->router->addRoute($args[0]);
        } else {
            throw new \Exception('Method not found');
        }
    }

    public function request($req)
    {
        if($route = $this->router->map($req)) {
            return $route->call($req);
        } else {
            // couldn't find a route, 404
        }
    }

    public function getRoutes()
    {
        return $this->router->getRoutes();
    }
}
