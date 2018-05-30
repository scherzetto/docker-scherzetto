<?php

namespace Tests\Lib\Db\Orm;

use Lib\Db\Orm\Manager;
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
