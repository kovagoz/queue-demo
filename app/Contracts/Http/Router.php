<?php

namespace App\Contracts\Http;

interface Router
{
    /**
     * Declare a GET route.
     *
     * @param string   $path
     * @param callable $controller
     * @return self
     */
    public function get($path, callable $controller);

    /**
     * Declare a POST route.
     *
     * @param string   $path
     * @param callable $controller
     * @return self
     */
    public function post($path, callable $controller);

    /**
     * Match a route against a request.
     *
     * @param Request $request
     * @return mixed
     */
    public function match(Request $request);
}
