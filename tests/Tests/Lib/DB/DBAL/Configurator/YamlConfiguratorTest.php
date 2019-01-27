<?php
/**
 * Created by PhpStorm.
 * User: benjamin
 * Date: 27/01/19
 * Time: 14:26
 */

namespace Tests\Lib\DB\DBAL\Configurator;

use Lib\DB\DBAL\Configurator\YamlConfigurator;
use Tests\TestCase;

class YamlConfiguratorTest extends TestCase
{
    /** @var YamlConfigurator */
    private $configurator;

    public function setUp()
    {
        $this->configurator = new YamlConfigurator();
    }

    public function testGetParams()
    {
        $result = $this->configurator->getParams();
        $this->assertIsArray($result);
        $this->assertArrayHasKey(0, $result);
        $this->assertArrayHasKey('dbname', $result[0]);
    }
}
