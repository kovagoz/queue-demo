<?php

namespace App\Queue\Drivers\Amqp;

use App\Contracts\Queue\Queue as QueueContract;
use App\Contracts\Queue\MessageHandler;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Channel\AMQPChannel;
use Closure;

class Queue implements QueueContract
{
    /**
     * Create new queue.
     *
     * @param AMQPChannel $channel
     * @param string      $name
     */
    public function __construct(AMQPChannel $channel, $name)
    {
        $this->channel = $channel;
        $this->name    = $name;
    }

    /**
     * Put a message into the queue.
     *
     * @param mixed $message
     * @return self
     */
    public function put($message)
    {
        $message = new AMQPMessage($message);

        $this->channel->basic_publish($message, '', $this->name);

        return $this;
    }

    /**
     * Listen the queue for messages.
     *
     * @param MessageHandler $handler
     * @return void
     */
    public function listen(MessageHandler $handler)
    {
        $this->createConsumer($handler);

        while ($this->hasCallbacks()) {
            $this->channel->wait();
        }
    }

    /**
     * Remove all messages from the queue.
     *
     * @return self
     */
    public function purge()
    {
        $this->channel->queue_purge($this->name);

        return $this;
    }

    /**
     * Get the queue's name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Create a message consumer bind a handler to it.
     *
     * @param MessageHandler $handler
     * @return void
     */
    protected function createConsumer(MessageHandler $handler)
    {
        $callback = function ($message) use ($handler) {
            $result = call_user_func([$handler, 'handle'], new Message($message));
        };

        $this->channel->basic_consume(
            $this->name,
            '',
            false,
            $no_ack = false,
            false,
            false,
            $callback
        );
    }

    /**
     * Determine if there any listener on the channel.
     *
     * @return boolean
     */
    protected function hasCallbacks()
    {
        return (bool) count($this->channel->callbacks);
    }
}
