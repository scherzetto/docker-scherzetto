<?php

namespace Tests\Lib\DB\ORM;

use Lib\DB\ORM\HydratorDecoratorFactory;
use Lib\Routing\RouteDefinition;
use PHPUnit\Framework\TestCase;

class HydratorDecoratorFactoryTest extends TestCase
{
    /** @var HydratorDecoratorFactory */
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
    }

    public function testCreateHydratorForClassCreatesHydrator()
    {
        $hydratorClass = 'RouteDefinitionHydratorDecorator';

        $this->factory->createHydratorForClass(RouteDefinition::class, ['home', '/']);
        $hydrator = new $hydratorClass('home', '/');

        $this->assertInstanceOf(RouteDefinition::class, $hydrator);
    }

    public function testGetHydratorForClassReturnsPreviouslyInstanciatedHydrator()
    {
        $hydrator = $this->factory->getHydratorForClass(RouteDefinition::class, ['home', '/']);

        $this->assertInstanceOf(RouteDefinition::class, $hydrator);
    }

    public function testGetHydratorForClassWithObjectAsArg()
    {
        $hydrator = $this->factory->getHydratorForClass(new RouteDefinition('home', '/'), ['home', '/']);

        $this->assertInstanceOf(RouteDefinition::class, $hydrator);
    }
}
