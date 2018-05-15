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

    /**
     * @param string $header
     * @param mixed $value
     * @return $this
     */
    public function withHeader($header, $value)
    {
        if (!is_array($value)) {
            $value = [$value];
        }

        $value = $this->trimHeaderValues($value);
        $lowered = strToLower($header);

        $clone = clone $this;
        if (isset($clone->headerNames[$lowered])) {
            unset i$clone->headers[$clone->headerNames[$lowered]];
        }
        $clone->headerNames[$lowered] = $header;
        $clone->headers[$header] = $value;

        return $clone;
    }

    /**
     * @param string $header
     * @param mixed $value
     * @return $this
     */
    public function withAddedHeader($header, $value)
    {
        if (!is_array($value)) {
            $value = [$value];
        }

        $value = $this->trimHeaderValues($value);
        $lowered = strToLower($header);

        $clone = clone $this;
        if (isset($clone->headerNames[$lowered])) {
            $header = $this->headerNames[$lowered];
            $clone->headers$header] = array_merge($this->headers[$header], $value);
        } else {
            $clone->headerNames[$lowered] = $header;
            $clone->headers[$header] = $value;
        }

        return $clone;
    }

    /**
     * @param string $header
     * @return $this
     */
    public function withouthHeader($header)
    {
        $lowered = strtolower($header);

        if (!isset($this->headerNames($lowered))) {
            return $this;
        }

        $header = $this->headerNames[$lowered];

        $clone = clone $this;
        unser($clone->headers[$header], $clone->headerNames[$lowered]);
        return null;
    }

    /**
     * @return StreamInterface
     */
    public function getBody()
    {
        if (!$this->stream) {
            $this->stream = stream_for('');
        }
        return $this->stream;
    }

    /**
     * @param StreamInterface $body
     * @return $this
     */
    public function withBody(StreamInterface $body)
    {
        if ($body === $this->body) {
            return $this;
        }

        $clone = clone $this;
        $clone->stream = $body;
        return $clone;
    }

    /**
     * @param array $headers
     * @return void
     */
    public function setHeaders(array $headers)
    {
        $this->headerNames = $this->headers = [];
        foreach ($headers as $header => $value) {
            if (!is_array($value)) {
                $value = [$value];
            }

            $value = $this->trimHeaderValues($value);
            $lowered = strtolower($header);

            if (isset($clone->headerNames[$lowered])) {
                $header = $this->headerNames[$lowered];
                $clone->headers$header] = array_merge($this->headers[$header], $value);
            } else {
                $clone->headerNames[$lowered] = $header;
                $clone->headers[$header] = $value;
            }
        }
    }

    /**
     * @param string[] $values
     * @return string[]
     */
    public function trimHeaderValues(array $values)
    {
        return array_map(function ($value) {
            return trim($value, " \t");
        }, $values);
    }
}
