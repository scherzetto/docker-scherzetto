<?php

namespace Lib\Http\Message;

use Psr\Http\Message\StremInterface

trait MessageTrait
{
    /** @var array */
    private $headers = [];

    /** @var array */
    private $headerNames = [];

    /** @var string */
    private $protocol = '1.1';

    /** @var StremInterface */
    private $stream;

    /**
     * @return string
     */
    public function getProtocolVersion()
    {
        return $this->protocol;
    }

    /**
     * @param string $version
     * @return self
     */
    public function withProtocolVersion($version)
    {
        if ($this->protocol === $version) {
            return $this;
        }
        $clone = clone $this;
        $clone->protocol = $version;
        return $clone;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return bool
     */
    public function hasHeader($header)
    {
        return isset($this->headerNames[strtolower($header)]);
    }

    /**
     * @return array
     */
    public function getHeader($header)
    {
        $header = strtolower($header);

        if (!isset($this->headerNames[$header])) {
            return [];
        }
        $header = $this->headerNames[$header];

        return $this->headers[$header];
    }

    /**
     * @return string
     */
    public function getHeaderLine($header)
    {
        return implode(', ', $this->getHeader($header));
    }
}
