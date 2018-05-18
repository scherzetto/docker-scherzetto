<?php

namespace MyBlog\App\Lib;

use GuzzleHttp\Psr7\Request;

class Request extends Request
{
    public static function createFromGlobals($param)
    {
        return new self();
    }
}
