<?php

namespace Lib\DB\DBAL;

use Lib\DB\DBAL\Connection\ConnectionInterface;
use Lib\DB\DBAL\Driver\DriverInterface;
use Lib\DB\DBAL\Driver\PDODriver;
use Symfony\Component\Yaml\Parser;

class Connection
{
    /** @var DriverInterface */
    private $driver;

    /** @var ConnectionInterface */
    private $conn;

    /** @var bool */
    private $isConnected = false;

    public function __construct()
    {
        $parser = new Parser();
        $config = $parser->parseFile(__DIR__.'/../../../../config/config.yml')['database'];
        [$params, $username, $password] = $this->createParams($config);
        $this->driver = new PDODriver();
        $this->conn = $this->driver->connect($params, $username, $password);
        $this->isConnected = true;
    }

    private function createParams($config)
    {
        $username = '';
        $password = '';
        $params = [];
        foreach ($config as $key => $val) {
            if ($key === 'username') {
                $username = $val;
                continue;
            }
            if ($key === 'password') {
                $password = $val;
                continue;
            }
            $params[$key] = $val;
        }
        return [$params, $username, $password];
    }
}
