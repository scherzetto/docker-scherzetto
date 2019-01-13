<?php

namespace Tests\Lib\DB\ORM;

use Lib\DB\ORM\Manager;
use PHPUnit\Framework\TestCase;

/**
 * @author yourname
 */
class ManagerTest extends TestCase
{
    public function testDummy()
    {
        $manager = new Manager();
        $this->assertInstanceOf(Manager::class, $manager);
    }
}
