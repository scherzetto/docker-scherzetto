<?php

namespace Lib\Db\Orm;

use Lib\Db\Dbal\Connection;

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
