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

    public function isDying()
    {
        if (!$this->message->has('application_headers')) {
            return false;
        }

        $headers = $this->message->get('application_headers')->getNativeData();

        if (!isset($headers['x-death'])) {
            return false;
        }

        foreach (array_reverse($headers['x-death']) as $key => $header) {
            if ($key === 0) {
                $queue = $header['queue'];
                $reject_counter = 0;
            }

            if ($header['queue'] === $queue) {
                if (++$reject_counter >= 2) {
                    return true;
                }
            }
        }

        return false;
    }
}
