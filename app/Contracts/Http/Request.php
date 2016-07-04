<?php

namespace App\Contracts\Http;

interface Request
{
    /**
     * Get the request path.
     *
     * @return string
     */
    public function getPath();

    /**
     * Set the request method.
     *
     * @param mixed $method
     * @return self
     */
    public function setMethod($method);

    /**
     * Get the request method.
     *
     * @return string
     */
    public function getMethod();

    /**
     * Get a GET parameter.
     *
     * @param string $param
     * @return mixed
     */
    public function getParam($param);

    /**
     * Check whether request has a given GET parameter.
     *
     * @param string $param
     * @return boolean
     */
    public function hasParam($param);
}
