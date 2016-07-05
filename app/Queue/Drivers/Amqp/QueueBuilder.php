<?php

namespace App\Queue\Drivers\Amqp;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Wire\AMQPTable;

class QueueBuilder
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var boolean
     */
    protected $durable = false;

    /**
     * @var array
     */
    protected $arguments = [];

    /**
     * Create new queue builder instance.
     *
     * @param AMQPChannel $channel
     */
    public function __construct(AMQPChannel $channel)
    {
        $this->channel = $channel;
    }

    /**
     * Set the queue name.
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set the queue durable.
     *
     * @return self
     */
    public function setDurable()
    {
        $this->durable = true;

        return $this;
    }

    /**
     * Set a TTL on the queue.
     *
     * @param integer $ms
     * @return self
     */
    public function setTimeout($ms)
    {
        $this->arguments['x-message-ttl'] = $ms;

        return $this;
    }

    /**
     * Remove the TTL from the queue.
     *
     * @return self
     */
    public function setNoTimeout()
    {
        unset($this->arguments['x-message-ttl']);

        return $this;
    }

    /**
     * Set the dead letter exchange.
     *
     * @param mixed $queue
     * @return self
     */
    public function setDeadLetterExchange($queue)
    {
        if ($queue instanceof Queue) {
            $queue = $queue->getName();
        }

        $this->arguments['x-dead-letter-exchange'] = $queue;
        $this->arguments['x-dead-letter-routing-key'] = $queue;

        return $this;
    }

    /**
     * Unset the reference to the dead letter exchange.
     *
     * @param mixed $queue
     * @return self
     */
    public function setNoDeadLetterExchange($queue)
    {
        if ($queue instanceof Queue) {
            $queue = $queue->getName();
        }

        unset($this->arguments['x-dead-letter-exchange']);
        unset($this->arguments['x-dead-letter-routing-key']);

        return $this;
    }

    /**
     * Build the queue object.
     *
     * @return Queue
     */
    public function getQueue()
    {
        $this->createDirectExchange();
        $this->createQueue();
        $this->bindQueueToExchange();

        return new Queue($this->channel, $this->name);
    }

    /**
     * Create a direct exchange for the queue.
     *
     * @return void
     */
    protected function createDirectExchange()
    {
        $this->channel->exchange_declare($this->name, 'direct', false, false, false);
    }

    /**
     * Create the queue.
     *
     * @return void
     */
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

    /**
     * Bind the queue to the exchange with the same name.
     *
     * @return void
     */
    protected function bindQueueToExchange()
    {
        // Parameters: queue, exchange, routing key.
        $this->channel->queue_bind($this->name, $this->name, $this->name);
    }
}
