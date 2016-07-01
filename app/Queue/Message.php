<?php

namespace App\Queue;

use PhpAmqpLib\Message\AMQPMessage;

class Message
{
    public $message;

    public function __construct(AMQPMessage $message)
    {
        $this->message = $message;
    }

    public function getPayload()
    {
        return $this->message->body;
    }

    public function done()
    {
        $this->message->delivery_info['channel']->basic_ack(
            $this->message->delivery_info['delivery_tag']
        );
    }

    public function reject()
    {
        $this->message->delivery_info['channel']->basic_reject(
            $this->message->delivery_info['delivery_tag'],
            false
        );
    }
}
