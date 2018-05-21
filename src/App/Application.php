<?php

namespace App;

use App\Lib\Routing\Router;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Application
{
    protected $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    public function handleRequest(RequestInterface $request): ResponseInterface
    {
        list($controller, $action, $params) = $this->router->route($request);

        $response = 'App\\Controller\\'.$controller::create()->$action($request);

        return $response;
    }
}
