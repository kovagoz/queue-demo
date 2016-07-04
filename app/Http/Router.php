<?php

namespace App\Http;

use App\Contracts\Http\Router as RouterContract;
use App\Contracts\Http\Request as RequestContract;
use App\Http\Exceptions\PageNotFoundException;

/**
 * A very, very simple URL router.
 */
class Router implements RouterContract
{
    /**
     * @var array
     */
    protected $routes = [];

    /**
     * Declare a GET route.
     *
     * @param string   $path
     * @param callable $controller
     * @return self
     */
    public function get($path, callable $controller)
    {
        $this->routes['GET'][$path] = $controller;

        return $this;
    }

    /**
     * Declare a POST route.
     *
     * @param string   $path
     * @param callable $controller
     * @return self
     */
    public function post($path, callable $controller)
    {
        $this->routes['POST'][$path] = $controller;

        return $this;
    }

    /**
     * Match a route against a request.
     *
     * @param RequestContract $request
     * @return mixed
     */
    public function match(RequestContract $request)
    {
        $method = $request->getMethod();
        $path   = $request->getPath();

        if (isset($this->routes[$method][$path])) {
            return $this->routes[$method][$path];
        }

        throw new PageNotFoundException($request);
    }
}
