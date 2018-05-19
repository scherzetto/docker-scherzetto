<?php

namespace App\Lib;

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
    }

    public static function createFromGlobals()
    {
        return new self($_GET, $_POST, $_COOKIE, $_SERVER, $_FILES);
    }
}
