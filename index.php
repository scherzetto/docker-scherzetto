<?php

use App\Application;
use App\Lib\Request;

require __DIR__.'/vendor/autoload.php';

$request = Request::createFromGlobals();
$app = new Application();

$send = $app->handleRequest($request);
$sender->sendResponse();
