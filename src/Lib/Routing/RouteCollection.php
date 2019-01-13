<?php

namespace Lib\Routing;

class RouteCollection
{
    protected $routes = [];

    public function add(string $name, RouteDefinition $route)
    {
        if (!isset($this->routes['$name'])) {
            $this->routes[$name] = $route;
            return true;
        }
        throw new \InvalidArgumentException("The route {$name} already exists.");
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
