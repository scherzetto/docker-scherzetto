<?php

declare(strict_types=1);

namespace Lib\Http;

use GuzzleHttp\Psr7\Request as BaseRequest;

class Request extends BaseRequest
{
    const METHOD_HEAD = 'HEAD';
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';

    protected $query;
    protected $request;
    protected $cookie;
    protected $server;
    protected $files;

    /**
     * undocumented function.
     */
    public function __construct($query = [], $request = [], $cookie = [], $server = [], $files = [])
    {
        $this->query = new ParamCollection($query);
        $this->request = new ParamCollection($request);
        $this->cookie = new ParamCollection($cookie);
        $this->server = new ServerCollection($server);
        $this->files = new ParamCollection($files);

        $method = $this->server->has('REQUEST_METHOD') ? $this->server->get('REQUEST_METHOD') : 'GET';

        $requestUri = '/';
        if ($this->server->has('REQUEST_URI')) {
            $requestUri = $this->server->get('REQUEST_URI');
        } elseif ($this->server->has('ORIG_PATH_INFO')) {
            $requestUri = $this->server->get('ORIG_PATH_INFO');
            $this->server->set('REQUEST_URI', $requestUri);
        }

        $version = $this->server->has('SERVER_PROTOCOL') ?? mb_substr($this->server->get('SERVER_PROTOCOL'), -3) ?? '1.1';

        parent::__construct($method, $requestUri, $this->server->getHeaders(), http_build_query($this->request->all()), $version);
    }

    public static function createFromGlobals()
    {
        array_walk($_GET, 'htmlspecialchars');
        array_walk($_POST, 'htmlspecialchars');
        array_walk($_COOKIE, 'htmlspecialchars');

        return new self(
            $_GET,
            $_POST,
            $_COOKIE,
            $_SERVER,
            $_FILES
        );
    }
}
