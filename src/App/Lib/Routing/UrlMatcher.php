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

            if (preg_match('#^'.$regex.'$#', $path, $matches)) {
                $params = array_filter($matches, function ($key) {
                    return !is_int($key);
                }, ARRAY_FILTER_USE_KEY);
                return [
                    'controller' => $route->getDefault('controller'),
                    'action'     => $route->getDefault('action'),
                    'params'     => $params
                ];
            }
        }
    }

    private function createRegex(RouteDefinition $route): string
    {
        $regex = $route->getPathRegex();
        $reqs  = $route->getRequirements();
        $regex = preg_replace_callback(
            '/{(\w+)}/',
            function ($matches) use ($reqs) {
                $req = $reqs[$matches[1]] ?? '.+';
                return "(?<{$matches[1]}>{$req})";
            },
            $regex
        );

        return $regex;
    }
}
