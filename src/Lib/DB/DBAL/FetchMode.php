<?php

declare(strict_types=1);

namespace Lib\DB\DBAL;

use PDO;

/**
 * Class FetchMode.
 */
final class FetchMode
{
    // @codeCoverageIgnoreStart

    /**
     * @see PDO::ATTR_DEFAULT_FETCH_MODE
     */
    public const DEFAULT = PDO::ATTR_DEFAULT_FETCH_MODE;

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
        'DEFAULT' => self::DEFAULT,
        'ASSOC' => self::ASSOC,
        'NUMERIC' => self::NUMERIC,
        'MIXED' => self::MIXED,
        'STD_OBJ' => self::STD_OBJ,
        'CUSTOM_CLASS' => self::CUSTOM_CLASS,
    ];

    /**
     * FetchMode constructor.
     * This class cannot be instantiated.
     */
    private function __construct()
    {
    }
    // @codeCoverageIgnoreEnd
}
