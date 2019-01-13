<?php

namespace Tests\Lib\Db\Dbal;

use Lib\Db\Dbal\Connection;
use Lib\Db\Dbal\Dbal;
use PHPUnit\Framework\TestCase;

class DbalTest extends TestCase
{
    private $conn;
    private $dbal;

    public function setUp()
    {
        $this->conn = new Connection();
        $this->dbal = new Dbal($this->conn);
    }

    public function testTemp()
    {
    }
}
