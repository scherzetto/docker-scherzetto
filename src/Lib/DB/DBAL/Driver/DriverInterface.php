<?php
/**
 * Created by PhpStorm.
 * User: benjamin
 * Date: 13/01/19
 * Time: 22:47
 */

namespace Lib\DB\DBAL\Driver;

use Lib\DB\DBAL\Connection\ConnectionInterface;

interface DriverInterface
{
    public function connect(array $params, $username, $password): ConnectionInterface;
}
