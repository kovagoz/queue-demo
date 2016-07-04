<?php

namespace App\Contracts\Http;

interface Response
{
    /**
     * Set a HTTP response header.
     *
     * If header already exists it will be overwritten.
     *
     * @param string $name
     * @param string $value
     * @return self
     */
    public function setHeader($name, $value);

    /**
     * Set the response body.
     *
     * @param mixed $body
     * @return self
     */
    public function setBody($body);

    /**
     * Set the response status code.
     *
     * @param integer $status
     * @return self
     */
    public function setStatus($status);

    /**
     * Send the response to the client.
     *
     * @return void
     */
    public function send();
}
