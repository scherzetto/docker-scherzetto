<?php

namespace App\Lib\Controller;

use App\Lib\Templating\Templater;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractController
{
    /**
     * @var Templater
     */
    private $templater;

    public function __construct()
    {
        $this->templater = Templater::getTemplater();
    }

    public static function create()
    {
        return new self();
    }

    public function render($template, array $params): ResponseInterface
    {
        $view = $this->templater->render($template, $params);

        return $this->returnResponse($view);
    }

    public function returnResponse($body = '', $statusCode = 200): ResponseInterface
    {
        $headers = [
            'Content-Type' => ['text/html; charset=UTF-8'],
            'Cache-Control' => ['max-age=172800', 'public']
        ];

        return new Response($statusCode, $headers, $body);
    }
}
