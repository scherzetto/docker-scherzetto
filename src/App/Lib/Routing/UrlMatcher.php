<?php

namespace App\Lib\Routing;

class UrlMatcher
{
    /**
     * @var RouteCollection
     */
    private $collection;

    public function __construct(RouteCollection $collection)
    {
        $this->collection = $collection;
    }

    public function match($path)
    {
        if ($match = $this->matchCollection($path)) {
            return $match;
        }
        return ['controller' => 'Default', 'action' => 'notFound', 'params' => []];
    }

    public function matchCollection($path)
    {
        foreach ($this->collection->all() as $route) {
            $regex = $this->createRegex($route);

            if (preg_match($regex, $path, $matches)) {
                array_slice($matches, 0, 1);
                return [$route->getDefault('controller'), $route->getDefault('action'), $matches];
            }
        }
    }

    private function createRegex(RouteDefinition $route): string
    {
        $regex = $route->getPathRegex();
        $reqs  = $route->getRequirements();
        preg_replace_callback(
            '/{(\w+)}/',
            function ($m) use ($reqs) {
                $req = $reqs[$m[1]] ?? '.+';
                return "(?<{$m[1]}>{$req})";
            },
            $regex
        );

        return $regex;
    }
}
