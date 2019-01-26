<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: benjamin
 * Date: 26/01/19
 * Time: 21:39.
 */

namespace Lib\DB\DBAL\Configurator;

interface ConfiguratorInterface
{
    public function getParams(): array;
}
