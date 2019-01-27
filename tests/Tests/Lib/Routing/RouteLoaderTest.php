<?php

declare(strict_types=1);

namespace Tests\Lib\Routing;

use Lib\Routing\RouteCollection;
use Lib\Routing\RouteLoader;
use Tests\TestCase;

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
