<?php

namespace Lib\Http;

use Lib\Http\ParamCollection;

class ServerCollection extends ParamCollection
{
    public function getHeaders()
    {
        $headers = [];
        $contentHeaders = ['CONTENT_LENGTH' => true, 'CONTENT_MD5' => true, 'CONTENT_TYPE' => true];

        foreach ($this->parameters as $key => $value) {
            if (0 === stripos($key, 'HTTP_')) {
                $headers[substr($key, 5)] = $value;
            } elseif (isset($contentHeaders[$key])) {
                $headers[$key] = $value;
            }
        }

        return $headers;
    }
}
