<?php

declare(strict_types=1);

namespace Lib\Http;

class ServerCollection extends ParamCollection
{
    // @codeCoverageIgnoreStart
    public function getHeaders()
    {
        $headers = [];
        $contentHeaders = ['CONTENT_LENGTH' => true, 'CONTENT_MD5' => true, 'CONTENT_TYPE' => true];

        foreach ($this->parameters as $key => $value) {
            if (0 === mb_stripos($key, 'HTTP_')) {
                $headers[mb_substr($key, 5)] = $value;
            } elseif (isset($contentHeaders[$key])) {
                $headers[$key] = $value;
            }
        }

        return $headers;
    }

    // @codeCoverageIgnoreEnd
}
