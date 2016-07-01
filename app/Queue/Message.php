<?php

namespace App\Queue;

class Message
{
    public $payload;

    public function __construct($payload)
    {
        $this->payload = $payload;
    }
}
