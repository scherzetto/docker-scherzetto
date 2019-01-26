<?php

declare(strict_types=1);

namespace Lib\Env;

use Lib\Env\Exception\EnvException;
use Lib\Env\Exception\PathException;
use Lib\Env\Parser\EnvParserInterface;

final class EnvVarsSetter
{
    private const DIST_EXT = '.dist';

    private const ENV_DEV = 'dev';
    private const ENV_TEST = 'test';
    private const ENV_PROD = 'prod';

    /** @var array */
    private $envVars;

    /** @var EnvParserInterface */
    private $parser;

    public function __construct(EnvParserInterface $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @param string $path
     * @param string $envVarName
     * @param string $defaultEnv
     * @param array $testEnvs
     * @throws EnvException
     */
    public function loadEnv(string $path, string $envVarName = 'APP_ENV', string $defaultEnv = 'dev', $testEnvs = ['test']): void
    {
        $file = '';
        if (null === $env = $_SERVER[$envVarName] ?? $_ENV[$envVarName] ?? null) {
            $this->envVars[$envVarName] = $env = $defaultEnv;
        }
        if (file_exists($path) && !file_exists($file = "$path.dist")) {
            $this->doLoad($path);
        } else {
            $this->doLoad($file);
        }

        if (!\in_array($env, $testEnvs, true) && file_exists($file = "$path.local")) {
            $this->doLoad($file);
        }
        foreach (["$path.$env", "$path.$env.local"] as $file) {
            if (file_exists($file)) {
                $this->doLoad($file);
            }
        }
    }

    /**
     * @param string $path
     * @throws EnvException
     */
    public function doLoad(string $path)
    {
        if (!is_readable($path) || is_dir($path)) {
            throw new PathException();
        }
        try {
            $this->populate($path);
        } catch (EnvException $e) {
            throw $e;
        }
    }

    private function populate(string $path, bool $override = false): void
    {
        $vars = $this->parser->parse(file_get_contents($path));
        foreach ($vars as $varName => $value) {
            $httpVar = 0 !== strpos($varName, 'HTTP_');

            if (!$override && (isset($_ENV[$varName]) || ($httpVar && isset($_SERVER[$varName])))) {
                continue;
            }

            putenv("$varName=$value");
            $this->envVars[$varName] = $_ENV[$varName] = $value;
            if ($httpVar) {
                $_SERVER[$varName] = $value;
            }
        }
    }
}
