<?php

namespace App\Queue;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Wire\AMQPTable;

class QueueBuilder
{
    protected $name;

    protected $durable = false;

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

    public function setTimeout($ms)
    {
        $this->arguments['x-message-ttl'] = $ms;

        return $this;
    }

    public function setNoTimeout()
    {
        unset($this->arguments['x-message-ttl']);

        return $this;
    }

    public function setDeadLetterExchange($queue)
    {
        if ($queue instanceof Queue) {
            $queue = $queue->getName();
        }

        $this->arguments['x-dead-letter-exchange'] = $queue;
        $this->arguments['x-dead-letter-routing-key'] = $queue;

        return $this;
    }

    public function getQueue()
    {
        $this->createDirectExchange();
        $this->createQueue();
        $this->bindQueueToExchange();

        return new Queue($this->channel, $this->name);
    }

    protected function createDirectExchange()
    {
        $this->channel->exchange_declare($this->name, 'direct', false, false, false);
    }

    protected function createQueue()
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
    }

    protected function bindQueueToExchange()
    {
        // Parameters: queue, exchange, routing key.
        $this->channel->queue_bind($this->name, $this->name, $this->name);
    }
}
