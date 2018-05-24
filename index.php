<?php

use Lib\Application;
use Lib\Http\Request;
use Lib\Http\ResponseSender;

require __DIR__.'/vendor/autoload.php';

$app      = new Application();
$request  = Request::createFromGlobals();
$response = $app->handleRequest($request);

$sender = new ResponseSender($response);
$sender->sendResponse();
