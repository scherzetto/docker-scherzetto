<?php

namespace Lib\Db\Dbal;

use \PDO;

/**
 * Class FetchMode
 * @package Lib\Db\Dbal
 */
final class FetchMode
{
    /**
     * @see PDO::FETCH_ASSOC
     */
    public const ASSOC = PDO::FETCH_ASSOC;

    /**
     * @see PDO::FETCH_NUM
     */
    public const NUMERIC = PDO::FETCH_NUM;

    /**
     * @see PDO::FETCH_BOTH
     */
    public const MIXED = PDO::FETCH_BOTH;

    /**
     * @see PDO::FETCH_OBJ
     */
    public const STD_OBJ = PDO::FETCH_OBJ;

    /**
     * @see PDO::FETCH_CLASS
     */
    public const CUSTOM_CLASS = PDO::FETCH_CLASS;

    /**
     * Allowed fetch modes.
     */
    public const ALLOWED_MODES = [
        'ASSOC' => self::ASSOC,
        'NUMERIC' => self::NUMERIC,
        'MIXED' => self::MIXED,
        'STD_OBJ' => self::STD_OBJ,
        'CUSTOM_CLASS' => self::CUSTOM_CLASS
    ];

    /**
     * FetchMode constructor.
     * This class cannot be instantiated.
     */
    private function __construct()
    {
    }
}
