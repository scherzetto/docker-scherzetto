<?php

namespace Tests\Lib\Access;

use Lib\Access\Accessor;
use Lib\Routing\RouteDefinition;
use PHPUnit\Framework\TestCase;

class AccessorTest extends TestCase
{
    private $accessor;

    public function setUp()
    {
        $this->accessor = new Accessor();
    }

    public function testReadValueReturnsCorrectValue()
    {
        $route = new RouteDefinition('home', '/');

        $valueGet = $this->accessor->readValue($route, 'name');
        $valueIs = $this->accessor->readValue($route, 'auth');

        $this->assertEquals('home', $valueGet);
        $this->assertEquals('', $valueIs);
    }

    public function testReadValueReturnsFalseIfWrongProp()
    {
        $route = new RouteDefinition('home', '/');

        $value = $this->accessor->readValue($route, 'blob');

        $this->assertFalse($value);
    }

    public function testWriteValueWritesIfSetterExists()
    {
        $route = new RouteDefinition('home', '/');

        $this->accessor->writeValue($route, 'defaults', ['foo' => 'bar']);

        $this->assertEquals(['foo' => 'bar'], $route->getDefaults());
    }

    public function testWriteValueDoesNotWriteIfSetterNotExists()
    {
        $route = new RouteDefinition('home', '/');

        $this->accessor->writeValue($route, 'name', 'foo');

        $this->assertEquals('home', $route->getName());
    }
}
