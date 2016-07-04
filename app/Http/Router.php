<?php

namespace App\Http;

class Router
{
    protected $routes = [];

    public function get($path, callable $controller)
    {
        $this->routes['GET'][$path] = $controller;
    }

    public function post($path, callable $controller)
    {
        $this->routes['POST'][$path] = $controller;
    }

    public function match(Request $request)
    {
        $method = $request->getMethod();
        $path   = $request->getPath();

        if (isset($this->routes[$method][$path])) {
            return $this->routes[$method][$path];
        }

        throw new Exception;
    }
}
