<?php

namespace App\Lib;

class ParamCollection
{
    protected $parameters;

    public function __construct(array $params = array())
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
        return array_key_exists($this->parameters, $key) ? $this->parameters[$key] : $default;
    }

    public function has($key)
    {
        return array_key_exists($this->parameters, $key);
    }

    public function set($key, $value)
    {
        $this->parameters[$key] = $value;
    }
}
