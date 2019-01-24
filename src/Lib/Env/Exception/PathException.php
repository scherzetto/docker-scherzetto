<?php

namespace Lib\Env\Exception;

use Throwable;

class PathException extends EnvException
{
    public function __construct(string $message = 'Env file path cannot be read.', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
