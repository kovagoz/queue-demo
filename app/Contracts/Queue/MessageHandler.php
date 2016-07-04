<?php

namespace App\Contracts\Queue;

interface MessageHandler
{
    public function handle(Message $message);
}
