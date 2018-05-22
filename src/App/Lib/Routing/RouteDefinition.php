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
    private $requirements;
    /**
     * @var array
     */
    private $defaults = ['controller' => 'Default', 'action' => 'notFound'];
    /**
     * @var bool
     */
    private $auth;
    /**
     * @var array
     */
    private $params;

    /**
     * undocumented function
     *
     * @return void
     */
    public function __construct(string $name, string $pathRegex, array $requirements = [], array $defaults = [], bool $auth = false, array $params = [])
    {
        $this->name         = $name;
        $this->pathRegex    = $pathRegex;
        $this->requirements = $requirements;
        $this->defaults     = $defaults;
        $this->auth         = $auth;
        $this->params       = array_merge($this->params, $params);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPathRegex(): string
    {
        return $this->pathRegex;
    }

    public function getRequirements(): array
    {
        return $this->requirements;
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

    public function getParams(): array
    {
        return $this->params;
    }

    public function getParam($name)
    {
        return isset($this->params[$name]) ? $this->params[$name] : false;
    }
}
