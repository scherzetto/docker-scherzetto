<?php

use Lib\Application;
use Lib\Env\EnvVarsSetter;
use Lib\Env\Parser\DotenvParser;
use Lib\Http\Request;
use Lib\Http\ResponseSender;

require __DIR__ . '/../vendor/autoload.php';

$env = getenv('APP_ENV') ?? EnvVarsSetter::ENV_DEV;
(new EnvVarsSetter(new DotenvParser()))->loadEnv('../.env', 'APP_ENV', $env);

$app      = new Application();
$request  = Request::createFromGlobals();
$response = $app->handleRequest($request);

$sender = new ResponseSender($response);
$sender->sendResponse();
