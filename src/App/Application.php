<?php

namespace App;

use App\Lib\Routing\Router;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Application
{
    protected $router;

    public function __construct(Router $router = null)
    {
        $this->router = $router ?? new Router();
    }

    public function handleRequest(RequestInterface $request): ResponseInterface
    {
        $keys = ['controller' => true, 'action' => true, 'params' => true];

        extract(array_intersect_key($this->router->route($request), $keys));
        $controller .= 'Controller';
        $action     .= 'Action';

        $namespace =  '\\App\\Controller\\';
        if (!class_exists($namespace.$controller)) {
            $namespace =  '\\App\\Lib\\Controller\\';
        }
        $response = ($namespace.$controller)::create()->$action($request, ...$params);

        return $response;
    }
}
