<?php

namespace Tests\App\Lib\Routing;

use App\Lib\Routing\RouteCollection;
use App\Lib\Routing\RouteLoader;
use PHPUnit\Framework\TestCase;

class RouteLoaderTest extends TestCase
{
    public function testLoadRoutesLoadsFromDefaultPathWithNoArg()
    {
        $loader = new RouteLoader();
        $collection = $loader->loadRoutes();

        $this->assertInstanceOf(RouteCollection::class, $collection);
        $this->assertEquals(1, $collection->count());
    }

    public function testLoadRoutesLoadsWithArg()
    {
        $loader = new RouteLoader('tests/fixtures/routing.yml');
        $collection = $loader->loadRoutes();

        $this->assertInstanceOf(RouteCollection::class, $collection);
        $this->assertEquals(3, $collection->count());
    }
}
