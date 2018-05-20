<?php

use App\Application;
use App\Lib\Http\Request;
use App\Lib\Http\ResponseSender;

require __DIR__.'/vendor/autoload.php';

$app      = new Application();
$request  = Request::createFromGlobals();
$response = $app->handleRequest($request);

$sender = new ResponseSender($response);
$sender->sendResponse();
