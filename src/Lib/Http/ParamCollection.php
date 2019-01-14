<?php

declare(strict_types=1);

namespace Lib\Http;

class ParamCollection
{
    protected $parameters;

    public function __construct(array $params = [])
    {
        $this->parameters = $params;
    }

    public function all()
    {
        return $this->parameters;
    }

    public function keys()
    {
        return array_keys($this->parameters);
    }

    public function get($key, $default = null)
    {
        return array_key_exists($key, $this->parameters) ? $this->parameters[$key] : $default;
    }

    public function has($key)
    {
        return array_key_exists($key, $this->parameters);
    }

    public function set($key, $value)
    {
        $this->parameters[$key] = $value;
    }
}
