<?php

namespace Lib\Db\Dbal;

class Dbal
{
    private $conn;

    public function __construct(?Connection $conn)
    {
        $this->conn = $conn ?? new Connection();
    }

    public function beginTransaction()
    {
        return $this->conn->beginTransaction();
    }

    public function commit()
    {
        return $this->conn->commit();
    }

    public function exec(string $statement)
    {
        return $this->conn->exec($statement);
    }

    public function lastInsertId(string $name = null)
    {
        return $this->conn->lastInsertId($name);
    }

    public function prepare(string $statement, array $driverOptions = [])
    {
        return $this->conn->prepare($statement, $driverOptions);
    }

    public function query(string $statement, int $fetch = null, $arg3 = null, $ctorarg = null)
    {
        if ($fetch !== null) {
            return $this->conn->query($statement, $fetch, $arg3, $ctorarg);
        }
        return $this->conn->query($statement);
    }

    public function rollback()
    {
        return $this->conn->rollback();
    }
}
