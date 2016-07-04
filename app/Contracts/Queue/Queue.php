<?php

namespace App\Contracts\Queue;

interface Queue
{
    public function put($message);

    public function listen(MessageHandler $handler);
}
