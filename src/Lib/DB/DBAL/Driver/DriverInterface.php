<?php

declare(strict_types=1);

namespace Lib\DB\DBAL\Driver;

use Lib\DB\DBAL\Connection\ConnectionInterface;

interface DriverInterface
{
    public function connect(array $params, $username, $password): ConnectionInterface;
}
