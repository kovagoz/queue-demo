<?php

namespace App\Http;

class Response
{
    protected $headers = [];

    protected $body;

    protected $status;

    public function __construct($body = null)
    {
        $this->body = $body;
    }

    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function send()
    {
        if ($this->body === null) {
            $this->setStatus(204);
        }

        http_response_code($this->status ?: 200);

        if (is_array($this->body)) {
            $this->setBody(json_encode($this->body));
            $this->setHeader('Content-Type', 'application/json');
        }

        foreach ($headers as $name => $value) {
            header("{$name}: {$value}", true);
        }

        if ($this->body !== null) {
            echo $body;
        }
    }
}
