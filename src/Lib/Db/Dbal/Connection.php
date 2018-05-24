<?php

namespace Lib\Db\Dbal;

use PDO;
use Symfony\Component\Yaml\Parser;

class Connection extends PDO
{
    public function __construct()
    {
        $keys     = ['host', 'port', 'dbname', 'unix_socket', 'charset'];
        $parser   = new Parser();
        $config   = $parser->parseFile(__DIR__.'/../../../../config/config.yml')['database'];
        $dsn      = $config['type'].';';
        $userpass = [];

        foreach ($config as $key => val) {
            if (!\in_array($key, $keys)) {
                if (\in_array($key, ['username', 'password'])) {
                    $userpass[$key] = $val;
                }
                unset($config[$key]);
            }
        }
        foreach ($keys as $key) {
            if (isset($config[$key])) {
                $dsn .= "{$key}={$config[$key]};";
            }
        }
        parent::__construct($dsn, $userpass['username'], $userpass['password'], []);
    }
}
