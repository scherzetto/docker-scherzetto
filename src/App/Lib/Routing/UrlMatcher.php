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
        foreach ($this->collection as $name => $route) {
            if (preg_match($route->getPathRegex(), $path, $matches)) {
                return [$route->getDefault('controller'), $route->getDefault('action'), $route->getParams()];
            }
        }
    }
}
