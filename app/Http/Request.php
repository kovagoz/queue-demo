<?php

namespace App\Http;

use App\Contracts\Http\Request as RequestContract;

class Request implements RequestContract
{
    /**
     * @var string
     */
    protected $method = 'GET';

    /**
     * @var string
     */
    protected $path = '/';

    /**
     * @var array
     */
    protected $query = [];

    /**
     * Create new request instance.
     *
     * @param string $uri
     * @param string $method
     */
    public function __construct($uri, $method = null)
    {
        $this->setMethod($method);

        $parts = parse_url($uri);

        if (isset($parts['path'])) {
            $this->path = $parts['path'];
        }

        if (isset($parts['query'])) {
            parse_str($parts['query'], $this->query);
        }
    }

    /**
     * Get the request path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the request method.
     *
     * @param mixed $method
     * @return self
     */
    public function setMethod($method)
    {
        $method = trim(strtoupper($method));

        if (!empty($method)) {
            $this->method = $method;
        }

        return $this;
    }

    /**
     * Get the request method.
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Get a GET parameter.
     *
     * @param string $param
     * @return mixed
     */
    public function getParam($param)
    {
        if ($this->hasParam($param)) {
            return $this->query[$param];
        }
    }

    /**
     * Check whether request has a given GET parameter.
     *
     * @param string $param
     * @return boolean
     */
    public function hasParam($param)
    {
        return array_key_exists($param, $this->query);
    }

    /**
     * Create a request instance based on the PHP superglobals.
     *
     * @return self
     */
    public static function createFromGlobals()
    {
        return new self(
            $_SERVER['REQUEST_URI'],
            $_SERVER['REQUEST_METHOD']
        );
    }
}
