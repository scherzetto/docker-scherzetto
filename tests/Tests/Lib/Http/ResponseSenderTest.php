<?php

declare(strict_types=1);

namespace Tests\Lib\Http;

use Lib\Application;
use Lib\Http\Request;
use Lib\Http\ResponseSender;
use PHPUnit\Framework\TestCase;

class ResponseSenderTest extends TestCase
{
    private $application;
    private $response;
    private $sender;

    public function setUp()
    {
        $this->application = new Application();
        $this->response = $this->application->handleRequest(new Request([], [], [], ['REQUEST_URI' => '/dummy']));
        $this->sender = new ResponseSender($this->response);
    }

    public function testSendResponse()
    {
        ob_start();
        $this->sender->sendResponse();
        $echo = ob_get_clean();

        $this->assertTrue(headers_sent());
        $this->assertEquals('Not Found', $echo);
    }
}
