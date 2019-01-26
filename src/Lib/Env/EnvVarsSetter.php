<?php

declare(strict_types=1);

namespace Lib\Env;

use Lib\Env\Exception\EnvException;
use Lib\Env\Exception\PathException;
use Lib\Env\Parser\EnvParserInterface;

final class EnvVarsSetter
{
    public const ENV_DEV = 'dev';
    public const ENV_TEST = 'test';
    public const ENV_PROD = 'prod';
    private const DIST_EXT = '.dist';

    /** @var array */
    private $envVars;

    /** @var EnvParserInterface */
    private $parser;

    public function __construct(EnvParserInterface $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @param  string       $path
     * @param  string       $envVarName
     * @param  string       $defaultEnv
     * @param  array        $testEnvs
     * @throws EnvException
     */
    public function loadEnv(string $path, string $envVarName = 'APP_ENV', string $defaultEnv = self::ENV_DEV, $testEnvs = [self::ENV_TEST]): void
    {
        $file = '';
        if (null === $env = $_SERVER[$envVarName] ?? $_ENV[$envVarName] ?? null) {
            $this->envVars[$envVarName] = $env = $defaultEnv;
        }
        if (file_exists($path) && !file_exists($file = $path.self::DIST_EXT)) {
            $this->doLoad($path);
        } elseif (file_exists($file)) {
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
     * @param  string       $path
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

    /**
     * @param  string       $path
     * @param  bool         $override
     * @throws EnvException
     */
    private function populate(string $path, bool $override = false): void
    {
        try {
            $vars = $this->parser->parse(file_get_contents($path));
        } catch (EnvException $e) {
            throw $e;
        }
        foreach ($vars as $varName => $value) {
            $httpVar = 0 !== mb_strpos($varName, 'HTTP_');

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
