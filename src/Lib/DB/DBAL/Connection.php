<?php

declare(strict_types=1);

namespace Lib\DB\DBAL;

use Lib\DB\DBAL\Configurator\ConfiguratorInterface;
use Lib\DB\DBAL\Connection\ConnectionInterface;
use Lib\DB\DBAL\Driver\DriverInterface;

class Connection
{
    /** @var DriverInterface */
    private $driver;

    /** @var ConnectionInterface */
    private $conn;

    /** @var bool */
    private $isConnected = false;

    public function __construct(ConfiguratorInterface $configurator, DriverInterface $driver)
    {
        [$params, $username, $password] = $configurator->getParams();
        $this->driver = $driver;
        $this->conn = $this->driver->connect($params, $username, $password);
        $this->isConnected = true;
    }
}
