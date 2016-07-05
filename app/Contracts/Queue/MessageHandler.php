<?php

namespace App\Contracts\Queue;

interface MessageHandler
{
    /**
     * Process the given message.
     *
     * @param Message $message
     * @return void
     */
    public function handle(Message $message);
}
