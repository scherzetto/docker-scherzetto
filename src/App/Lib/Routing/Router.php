<?php

namespace App\Lib\Routing;

use Psr\Http\Message\RequestInterface;

class Router
{
    /**
     * @var UrlMatcher
     */
    private $matcher;
    /**
     * @var RouteLoader
     */
    private $loader;

    public function __construct()
    {
        $this->loader  = new RouteLoader()
        $collection    = $this->loader->loadRoutes();
        $this->matcher = new UrlMatcher($collection);
    }

    public function route(RequestInterface $request)
    {
        return $this->matcher->match($request->getUri()->getPath());
    }
}
