<?php

namespace Tests\Lib\Db\Dbal;

use Lib\Db\Dbal\Connection;
use PHPUnit\Framework\TestCase;

class ConnectionTest extends TestCase
{
    public function testConstruct()
    {
        $conn = new Connection();

        $this->assertInstanceOf(\PDO::class, $conn);
    }
}
