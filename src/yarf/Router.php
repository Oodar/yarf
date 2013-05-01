<?php

namespace yarf;

class Router
{
    private $routes;

    function __construct()
    {
        $this->routes = array();
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function addRoute($url, array $methods = array())
    {
        if(preg_match("#(:[a-z]+)$#", $url) > 0) {
            array_push($this->routes, new ParamRoute($url, $methods));
            return end($this->routes);
        } else {
            array_push($this->routes, new Route($url, $methods));
            return end($this->routes);
        }
    }

    public function map($req)
    {
        $matched = false;

        foreach ($this->routes as $route) 
        {
            if($route->isMatch($req)) {
                $matched = true;
                return $route;
            } else {
                // didn't match
            }
        }

        return $matched;
    }
}
