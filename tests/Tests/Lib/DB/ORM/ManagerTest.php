<?php

declare(strict_types=1);

namespace Tests\Lib\DB\ORM;

use Lib\DB\ORM\Manager;
use Lib\Env\EnvVarsSetter;
use Lib\Env\Parser\DotenvParser;
use PHPUnit\Framework\TestCase;

/**
 * @author yourname
 */
class ManagerTest extends TestCase
{
    public function testDummy()
    {
        (new EnvVarsSetter(new DotenvParser()))->loadEnv('.env');
        $manager = new Manager();
        $this->assertInstanceOf(Manager::class, $manager);
    }
}
