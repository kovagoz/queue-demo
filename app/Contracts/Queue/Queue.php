<?php

namespace App\Contracts\Queue;

interface Queue
{
    /**
     * Put a message into the queue.
     *
     * @param mixed $message
     * @return self
     */
    public function put($message);

    /**
     * Listen the queue for messages.
     *
     * @param MessageHandler $handler
     * @return void
     */
    public function listen(MessageHandler $handler);
}
