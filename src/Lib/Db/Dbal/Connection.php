<?php

namespace Lib\Db\Dbal;

use PDO;
use Symfony\Component\Yaml\Parser;

class Connection extends PDO
{
    const KEYS = ['host', 'port', 'dbname', 'unix_socket', 'charset'];

    public function __construct()
    {
        $parser = new Parser();
        $config = $parser->parseFile(__DIR__.'/../../../../config/config.yml')['database'];
        $params = $this->createParams($config);
        parent::__construct($params['dsn'], $params['username'], $params['password'], []);
    }


    public function createParams($config)
    {
        $params = [
            'dsn' => $config['type'].';'
        ];

        foreach ($config as $key => $val) {
            if (!\in_array($key, self::KEYS)) {
                if (\in_array($key, ['username', 'password'])) {
                    $params[$key] = $val;
                }
                unset($config[$key]);
            }
        }
        $params['dsn'] .= $this->createDsn($config);
        return $params;
    }

    public function createDsn($config)
    {
        $dsn = '';
        foreach (self::KEYS as $key) {
            if (isset($config[$key])) {
                $dsn .= "{$key}={$config[$key]};";
            }
        }
        return $dsn;
    }
}
