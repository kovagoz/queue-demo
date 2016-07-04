<?php

namespace App\Domain;

use App\Contracts\Queue\Queue;
use App\Contracts\Queue\MessageHandler;

class MessageProcessor
{
    protected $queue;

    protected $handler;

    public function __construct(Queue $queue, MessageHandler $handler)
    {
        $this->queue   = $queue;
        $this->handler = $handler;
    }

    public function start()
    {
        $this->queue->listen($this->handler);
    }
}
