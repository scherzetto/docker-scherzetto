<?php

namespace App\Lib\Routing;

use Symfony\Component\Yaml\Parser;

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

    /**
     * @var Parser
     */
    private $parser;

    public function __construct()
    {
        list($scriptName) = get_included_files();

        $this->rootDir   = dirname(realpath($scriptName));
        $this->routeFile = "{$this->rootDir}/config/routes.yml";
        $this->parser    = new Parser();
    }

    public static function loadRoutes()
    {
        $routes    = new RouteCollection();
        $routesArr = $this->parser->parseFile($this->routeFile);

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
