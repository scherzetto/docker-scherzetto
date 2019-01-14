<?php

declare(strict_types=1);

namespace Lib\DB\DBAL\Driver;

use Lib\DB\DBAL\Connection\ConnectionInterface;
use Lib\DB\DBAL\Connection\PDOConnection;
use PDO;

class PDODriver implements DriverInterface
{
    private const KEYS = ['host', 'port', 'dbname', 'unix_socket', 'charset'];

    public function connect(array $params, $username, $password): ConnectionInterface
    {
        $password = getenv('TEST') ? '' : $password;

        return new PDOConnection(
            $this->createDsn($params),
            $username,
            $password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]
        );
    }

    private function createDsn($params)
    {
        $dsn = 'mysql:';
        foreach (self::KEYS as $key) {
            if (isset($params[$key])) {
                $dsn .= "{$key}={$params[$key]};";
            }
        }

        return $dsn;
    }
}
