<?php

namespace App\Lib\Routing;

class RouteCollection
{
    protected $routes = [];

    public function add(string $name, Route $route)
    {
        $this->routes[$name] = $route;
    }

    public function get($name)
    {
        return isset($this->routes[$name]) ? $this->routes[$name] : false;
    }

    public function all()
    {
        return $this->routes;
    }
}
