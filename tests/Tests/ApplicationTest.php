<?php

namespace Tests;

use Lib\Application;
use Lib\Http\Request;
use Lib\Routing\Router;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    protected $app;

    /* @var \PHPUnit_Framework_MockObject_MockObject&Router */
    protected $router;

    public function setUp()
    {
        $this->router = $this
            ->getMockBuilder(Router::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->setMethods(['route'])
            ->getMock();

        $this->router
             ->expects($this->once())
             ->method('route')
             ->willReturn(['controller' => 'Default', 'action' => 'notFound', 'params' => []]);

        $this->app = new Application($this->router);
    }

    public function testRouterIsCalled()
    {
        $this->app->handleRequest(new Request());
    }

    public function testHandleRequestReturnsResponse()
    {
        $return = $this->app->handleRequest(new Request());
        $this->assertInstanceOf(Response::class, $return);
    }
}
