<?php

namespace App\Lib\Http;

use GuzzleHttp\Psr7\Request;

class Request extends Request
{
    const METHOD_HEAD = 'HEAD';
    const METHOD_GET  = 'GET';
    const METHOD_POST = 'POST';

    protected $query;
    protected $request;
    protected $cookie;
    protected $server;
    protected $files;

    /**
     * undocumented function
     *
     * @return void
     */
    public function __construct($query = array(), $request = array(), $cookie = array(), $server = array(), $files = array())
    {
        $this->query   = $query;
        $this->request = $request;
        $this->cookie  = $cookie;
        $this->server  = $server;
        $this->files   = $files;

        $method = $this->server->has('REQUEST_METHOD') ? $this->server->get('REQUEST_METHOD') : 'GET';

        if ($this->server->has('REQUEST_URI')) {
            $requestUri = $this->server->get('REQUEST_URI');
        } elseif ($this->has('ORIG_PATH_INFO')) {
            $requestUri = $this->server->get('ORIG_PATH_INFO');
            $this->server->set('REQUEST_URI', $requestUri);
        }

        $version = substr($_SERVER['SERVER_PROTOCOL'], -3);

        parent::__construct($method, $requestUri, $this->server->getHeaders(), $this->request, $version)
    }

    public static function createFromGlobals()
    {
        return new self($_GET, $_POST, $_COOKIE, $_SERVER, $_FILES);
    }
}
