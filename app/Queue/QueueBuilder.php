<?php

namespace App\Queue;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Wire\AMQPTable;

class QueueBuilder
{
    protected $name;

    protected $durable = false;

    protected $timeout;

    protected $arguments = [];

    public function __construct(AMQPChannel $channel)
    {
        $this->channel = $channel;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function setDurable()
    {
        $this->durable = true;

        return $this;
    }

    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;

        return $this;
    }

    public function setNoTimeout()
    {
        $this->timeout = null;

        return $this;
    }

    public function setDeadLetterExchange($queue)
    {
        if ($queue instanceof Queue) {
            $queue = $queue->getName();
        }

        $this->arguments['x-dead-letter-exchange'] = $queue;

        return $this;
    }

    public function getQueue()
    {
        $this->channel->queue_declare(
            $this->name,
            false,
            $this->durable,
            false,
            false,
            false,
            new AMQPTable($this->arguments)
        );

        return new Queue($this->channel, $this->name);
    }
}
