<?php

namespace Tests\Lib\Db\Orm;

use Lib\Db\Orm\HydratorDecoratorFactory;
use Lib\Routing\RouteDefinition;
use PHPUnit\Framework\TestCase;

class HydratorDecoratorFactoryTest extends TestCase
{
    private $factory;

    public function setUp()
    {
        $this->factory = new HydratorDecoratorFactory();
    }

    public function testCreateHydratorFileCreatesFile()
    {
        $file          = __DIR__.'/../../../../../../var/cache/tests/RouteDefinitionHydratorDecorator.php';
        $hydratorClass = 'RouteDefinitionHydratorDecorator';

        $this->factory->createHydratorFile(RouteDefinition::class, $hydratorClass, $file);
        include($file);
        $hydrator = new $hydratorClass('home', '/');

        $this->assertTrue(file_exists($file));
        $this->assertInstanceOf(RouteDefinition::class, $hydrator);
        unlink($file);
    }
}
