<?php

namespace Lib\DB\ORM;

use Lib\DB\DBAL\Connection;

class Manager
{
    /**
     * @var Connection
     */
    private $conn;

    public function __construct(Connection $conn = null)
    {
        $this->conn = $conn ?? new Connection();
    }
}
