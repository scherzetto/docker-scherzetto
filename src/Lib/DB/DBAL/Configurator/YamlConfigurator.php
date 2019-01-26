<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: benjamin
 * Date: 26/01/19
 * Time: 21:40.
 */

namespace Lib\DB\DBAL\Configurator;

use Symfony\Component\Yaml\Parser;

class YamlConfigurator implements ConfiguratorInterface
{
    public function getParams(): array
    {
        $parser = new Parser();
        $config = $parser->parseFile(__DIR__.'/../../../../config/config.yml')['database'];

        return $this->createParams($config);
    }

    private function createParams(array $config): array
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
