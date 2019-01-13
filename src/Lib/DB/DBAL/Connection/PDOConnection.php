<?php
/**
 * Created by PhpStorm.
 * User: benjamin
 * Date: 13/01/19
 * Time: 22:49
 */

namespace Lib\DB\DBAL\Connection;

use Lib\DB\DBAL\FetchMode;
use PDO;

class PDOConnection extends PDO implements ConnectionInterface
{
    /**
     * {@inheritdoc}
     */
    public function prepare($prepareString, $driverOptions = null)
    {
        try {
            parent::prepare($prepareString, $driverOptions);
        } catch (\PDOException $e) {
            throw new \PDOException($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function query($query, $mode = FetchMode::DEFAULT, $arg3 = null, array $ctorargs = [])
    {
        $argsCount = \count(func_get_args());
        try {
            if ($argsCount === 4) {
                return parent::query($query, $mode, $arg3, $ctorargs);
            }
            if ($argsCount === 3) {
                return parent::query($query, $mode, $arg3);
            }
            if ($argsCount === 2) {
                return parent::query($query, $mode);
            }
            return parent::query($query);
        } catch (\PDOException $e) {
            throw new \PDOException($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function exec($statement)
    {
        try {
            parent::exec($statement);
        } catch (\PDOException $e) {
            throw new \PDOException($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function lastInsertId($name = null)
    {
        try {
            parent::lastInsertId($name);
        } catch (\PDOException $e) {
            throw new \PDOException($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function beginTransaction()
    {
        try {
            parent::beginTransaction();
        } catch (\PDOException $e) {
            throw new \PDOException($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function commit()
    {
        try {
            parent::commit();
        } catch (\PDOException $e) {
            throw new \PDOException($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rollBack()
    {
        try {
            parent::rollBack();
        } catch (\PDOException $e) {
            throw new \PDOException($e);
        }
    }
}
