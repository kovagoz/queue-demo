<?php

namespace App\Queue\Drivers\Amqp;

use App\Contracts\Queue\Message as MessageContract;
use PhpAmqpLib\Message\AMQPMessage;

class Message implements MessageContract
{
    /**
     * @var AMQPMessage
     */
    public $message;

    /**
     * Create new message.
     *
     * @param AMQPMessage $message
     */
    public function __construct(AMQPMessage $message)
    {
        $this->message = $message;
    }

    /**
     * Get the raw message from the message object.
     *
     * @return mixed
     */
    public function getPayload()
    {
        return $this->message->body;
    }

    /**
     * Reject the message.
     *
     * @return void
     */
    public function reject()
    {
        $this->message->delivery_info['channel']->basic_reject(
            $this->message->delivery_info['delivery_tag'],
            false
        );
    }

    /**
     * Mark the message successfully processed.
     *
     * @return void
     */
    public function done()
    {
        $this->message->delivery_info['channel']->basic_ack(
            $this->message->delivery_info['delivery_tag']
        );
    }

    /**
     * Get the number of times message was rejected.
     *
     * @return integer
     */
    public function rejectCounter()
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
                $reject_counter++;
            }
        }

        return $reject_counter;
    }
}
