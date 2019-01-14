<?php

declare(strict_types=1);

namespace Lib\Routing;

use GuzzleHttp\Psr7\UriResolver;
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

    public function __construct(string $path = null)
    {
        $path = $path ? ltrim($path, '/') : 'config/routes.yml';

        $this->rootDir = UriResolver::removeDotSegments(__DIR__.'/../../../');
        $this->routeFile = "{$this->rootDir}{$path}";
        $this->parser = new Parser();
    }

    public function loadRoutes()
    {
        $routes = new RouteCollection();
        $routesArr = $this->parser->parseFile($this->routeFile);

        foreach ($routesArr as $name => $row) {
            $path = $row['path'];
            $requirements = $row['requirements'] ?? [];
            $defaults = $row['defaults'] ?? [];
            $auth = $row['auth'] ?? false;
            $params = $row['params'] ?? [];

            $route = new RouteDefinition($name, $path, $requirements, $defaults, $auth, $params);
            $routes->add($name, $route);
        }

        return $routes;
    }
}
