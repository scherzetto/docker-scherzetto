<?php

declare(strict_types=1);

namespace Lib\DB\ORM;

use Lib\DB\DBAL\Configurator\DotenvConfigurator;
use Lib\DB\DBAL\Connection;
use Lib\DB\DBAL\Driver\PDODriver;

class Manager
{
    /**
     * @var Connection
     */
    private $conn;

    public function __construct(Connection $conn = null)
    {
        $this->conn = $conn ?? new Connection(new DotenvConfigurator(), new PDODriver());
    }
}
