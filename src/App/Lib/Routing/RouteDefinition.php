<?php

namespace App\Lib\Routing;

class RouteDefinition
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $pathRegex;
    /**
     * @var array
     */
    private $params = ['controller' => 'Default', 'action' => 'notFound'];
    /**
     * @var array
     */
    private $defaults;
    /**
     * @var bool
     */
    private $auth;

    /**
     * undocumented function
     *
     * @return void
     */
    public function __construct(string $name, string $pathRegex, array $params = [], array $defaults = [], bool $auth = false)
    {
        $this->name      = $name;
        $this->pathRegex = $pathRegex;
        $this->params    = array_merge($this->params, $params);
        $this->defaults  = $defaults;
        $this->auth      = $auth;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPathRegex(): string
    {
        return $this->pathRegex;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function getParam($name)
    {
        return isset($this->params[$name]) ? $this->params[$name] : false;
    }

    public function getDefaults(): array
    {
        return $this->defaults;
    }

    public function getDefault($name)
    {
        return isset($this->defaults[$name]) ? $this->defaults[$name] : false;
    }

    public function addDefaults(array $defaults)
    {
        foreach ($defaults as $name => $default) {
            $this->defaults[$name] = $default;
        }
    }

    public function isAuth(): bool
    {
        return $this->auth;
    }
}
