<?php

namespace App\Domain;

use App\Contracts\Queue\Queue;
use App\Contracts\Queue\MessageHandler;

class MessageProcessor
{
    /**
     * @var Queue
     */
    protected $queue;

    /**
     * @var MessageHandler
     */
    protected $handler;

    /**
     * Create new message processor instance.
     *
     * @param Queue          $queue
     * @param MessageHandler $handler
     */
    public function __construct(Queue $queue, MessageHandler $handler)
    {
        $this->queue   = $queue;
        $this->handler = $handler;
    }

    /**
     * Start the processor.
     *
     * @return void
     */
    public function start()
    {
        $this->queue->listen($this->handler);
    }
}
