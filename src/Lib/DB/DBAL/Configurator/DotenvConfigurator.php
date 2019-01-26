<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: benjamin
 * Date: 26/01/19
 * Time: 21:54.
 */

namespace Lib\DB\DBAL\Configurator;

class DotenvConfigurator implements ConfiguratorInterface
{
    public function getParams(): array
    {
        $params = [
            'host' => getenv('APP_DB_HOST'),
            'port' => getenv('APP_DB_PORT'),
            'dbname' => getenv('APP_DB_NAME'),
        ];

        return [$params, getenv('APP_DB_USERNAME'), getenv('APP_DB_PASSWORD')];
    }
}
