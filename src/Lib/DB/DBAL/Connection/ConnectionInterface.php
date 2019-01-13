<?php
/**
 * Created by PhpStorm.
 * User: benjamin
 * Date: 13/01/19
 * Time: 22:34
 */

namespace Lib\DB\DBAL\Connection;

use Lib\DB\DBAL\FetchMode;

interface ConnectionInterface
{
    public function prepare($prepareString);

    public function query($query, $mode = FetchMode::DEFAULT, $arg3 = null, array $ctorargs = []);

    public function exec($statement);

    public function lastInsertId($name = null);

    public function beginTransaction();

    public function commit();

    public function rollBack();
}
