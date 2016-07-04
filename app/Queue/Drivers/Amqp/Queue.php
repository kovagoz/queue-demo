<?php

namespace App\Queue\Drivers\Amqp;

use App\Contracts\Queue\Queue as QueueContract;
use App\Contracts\Queue\MessageHandler;
use PhpAmqpLib\Message\AMQPMessage;
use Closure;

class Queue implements QueueContract
{
    public function __construct($channel, $name)
    {
        $this->channel = $channel;
        $this->name    = $name;
    }

    public function put($message)
    {
        $message = new AMQPMessage($message);

        $this->channel->basic_publish($message, '', $this->name);
    }

    public function listen(MessageHandler $handler)
    {
        $this->createConsumer($handler);

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

    protected function createConsumer($handler)
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
}
