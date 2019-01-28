<?php
/**
 * Created by PhpStorm.
 * User: benjamin
 * Date: 28/01/19
 * Time: 13:30.
 */

declare(strict_types=1);

namespace Tests\Lib\Http;

$headersSent = false;
function headers_sent()
{
    global $headersSent;

    return $headersSent;
}
