<?php

namespace App\Http;

use App\Contracts\Http\Response as ResponseContract;

class Response implements ResponseContract
{
    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @var mixed
     */
    protected $body;

    /**
     * @var integer
     */
    protected $status;

    /**
     * Create new HTTP response.
     *
     * @param mixed $body
     */
    public function __construct($body = null)
    {
        $this->body = $body;
    }

    /**
     * Set a HTTP response header.
     *
     * If header already exists it will be overwritten.
     *
     * @param string $name
     * @param string $value
     * @return self
     */
    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;

        return $this;
    }

    /**
     * Set the response body.
     *
     * @param mixed $body
     * @return self
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Set the response status code.
     *
     * @param integer $status
     * @return self
     */
    public function setStatus($status)
    {
        $this->status = intval($status);

        return $this;
    }

    /**
     * Send the response to the client.
     *
     * @return void
     */
    public function send()
    {
        if ($this->body === null && $this->status === null) {
            $this->setStatus(204);
        }

        $this->setFinalStatusCode();

        if (is_array($this->body)) {
            $this->setJsonResponse();
        }

        $this->sendHeaders();
        $this->sendBody();
    }

    /**
     * Set body and headers for a JSON response.
     *
     * @return void
     */
    protected function setJsonResponse()
    {
        $this->setBody(json_encode($this->body));
        $this->setHeader('Content-Type', 'application/json');
    }

    /**
     * Set the HTTP status code will be sent.
     *
     * @return void
     */
    protected function setFinalStatusCode()
    {
        http_response_code($this->status ?: 200);
    }

    /**
     * Send HTTP headers to the client.
     *
     * @return void
     */
    protected function sendHeaders()
    {
        foreach ($this->headers as $name => $value) {
            header("{$name}: {$value}", true);
        }
    }

    /**
     * Send the response body if not empty.
     *
     * @return void
     */
    protected function sendBody()
    {
        if ($this->body !== null) {
            echo $this->body;
        }
    }
}
