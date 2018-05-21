<?php

namespace App\Lib\Routing;

use Psr\Http\Message\RequestInterface;

class Router
{
    /**
     * @var UrlMatcher
     */
    private $matcher;

    public function __construct()
    {
        $collection = RouteLoader::loadRoutes();
        $this->matcher = new UrlMatcher($collection);
    }

    public function route(RequestInterface $request)
    {
        return $this->matcher->match($request->getUri()->getPath());
    }
}
