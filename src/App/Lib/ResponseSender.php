<?php

namespace App\Lib;

use Psr\Http\Message\ResponseInterface;

class ResponseSender
{
    protected $response;

    public function __construct(ResponseInterface $Response)
    {
        $this->response = $response;
    }

    public function sendResponse()
    {
        $this->sendHeaders();
        $this->sendContent();

        return $this;
    }

    public function sendHeaders()
    {
        $res = $this->response;

        if (headers_sent()) {
            return $this;
        }

        foreach ($res->getHeaders() as $name => $values) {
            foreach ($values as $value) {
                header($name.': '.$value, false, $res->getStatusCode())
            }
        }

        header(sprintf('HTTP/%s %s %s', $res->getProtocolVersion(), $res->getStatusCode(), $res->getReasonPhrase()))

        return $this;
    }

    public function sendContent()
    {
        echo (string) $this->response->getStream();

        return $this;
    }
}