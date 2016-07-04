<?php

namespace App\Http;

class Request
{
    protected $method;

    protected $path = '/';

    protected $query = [];

    public function __construct($method, $uri)
    {
        $this->method = $method;

        $parts = parse_url($uri);

        if (isset($parts['path']) {
            $this->path = $path;
        }

        if (isset($parts['query']) {
            parse_str($parts['query'], $this->query);
        }
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function get($param)
    {
        if (array_key_exists($param, $this->query) {
            return $this->query[$param];
        }
    }

    public static function createFromGlobals()
    {
        return new self(
            $_SERVER['REQUEST_METHOD'],
            $_SERVER['REQUEST_URI']
        );
    }
}
