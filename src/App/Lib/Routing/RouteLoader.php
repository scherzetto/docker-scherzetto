<?php

namespace App\Lib\Routing;

class RouteLoader
{
    /**
     * @var string
     */
    private $rootDir;
    /**
     * @var string
     */
    private $routeFile;

    public function __construct()
    {
        list($scriptName) = get_included_files();

        $this->rootDir   = dirname(realpath($scriptName));
        $this->routeFile = "{$this->rootDir}/config/routes.yml";
    }

    public static function loadRoutes()
    {
        $routes    = new RouteCollection();
        $routesArr = Yaml::parseFile($this->routeFile);

        $routesAttr = ['path', 'params', 'defaults', 'auth'];

        foreach ($routesArr as $name => $row) {
            $path     = $row['path'];
            $params   = $row['params'] ?? [];
            $defaults = $row['defaults'] ?? [];
            $auth     = $row['auth'] ?? false;

            $route = new RouteDefinition($name, $path, $params, $defaults, $auth);
            $routes->add($name, $route);
        }

        return $routes;
    }
}
