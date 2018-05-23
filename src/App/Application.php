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

        $attributes = $this->router->route($request);
        $controller = $attributes['controller'].'Controller';
        $action     = $attributes['action'].'Action';

        $namespace =  '\\App\\Controller\\';
        if (!class_exists($namespace.$controller)) {
            $namespace =  '\\App\\Lib\\Controller\\';
        }
        $response = ($namespace.$controller)::create()->$action($request, ...$attributes['params']);

        return $response;
    }
}
