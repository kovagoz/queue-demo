<?php

namespace App\Queue;

use PhpAmqpLib\Message\AMQPMessage;
use Closure;

class Queue
{
    public function __construct($channel, $name)
    {
        $this->channel = $channel;
        $this->name    = $name;
    }

    public function put($message)
    {
        if (!$message instanceof AMQPMessage) {
            $message = new AMQPMessage($message);
        }

        $this->channel->basic_publish($message, '', $this->name);
    }

    public function listen(Closure $callback)
    {
        $callback = function ($message) use ($callback) {
            call_user_func($callback, new Message($message->body));
        };

        $this->channel->basic_consume(
            $this->name,
            '',
            false,
            $no_ack = true,
            false,
            false,
            $callback
        );

        while (count($this->channel->callbacks)) {
            $this->channel->wait();
        }
    }

    public function purge()
    {
        $this->channel->queue_purge($this->name);
    }

    public function getName()
    {
        return $this->name;
    }
}
