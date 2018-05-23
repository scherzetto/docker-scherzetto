<?php

namespace Tests\App\Routing;

use App\Lib\Http\Request;
use App\Lib\Routing\RouteLoader;
use App\Lib\Routing\Router;
use App\Lib\Routing\UrlMatcher;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function testMatcherIsCalled()
    {
        $matcher = $this
            ->getMockBuilder(UrlMatcher::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disallowMockingUnknownTypes()
            ->setMethods(['match'])
            ->getMock();
        $loader = $this
            ->getMockBuilder(RouteLoader::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disallowMockingUnknownTypes()
            ->getMock();

        $router = new Router($loader, $matcher);

        $matcher->expects($this->once())->method('match');

        $router->route(new Request());
    }
}
