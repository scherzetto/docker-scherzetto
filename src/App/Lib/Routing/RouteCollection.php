<?php

namespace App\Lib\Routing;

class RouteCollection
{
    protected $routes = [];

    public function add(string $name, RouteDefinition $route)
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

    public function count()
    {
        return count($this->routes);
    }
}
