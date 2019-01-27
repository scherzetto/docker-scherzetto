<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: benjamin
 * Date: 27/01/19
 * Time: 15:11.
 */

namespace Tests;

use Lib\Env\EnvVarsSetter;
use Lib\Env\Parser\DotenvParser;
use PHPUnit\Framework\TestCase as BaseCase;

class TestCase extends BaseCase
{
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        (new EnvVarsSetter(new DotenvParser()))->loadEnv('.env');
        parent::__construct($name, $data, $dataName);
    }
}
