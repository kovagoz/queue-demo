<?php

namespace App\Domain;

use App\Contracts\Queue\Queue;

class MessageGenerator
{
    protected $queue;

    public function __construct(Queue $queue)
    {
        $this->queue = $queue;
    }

    public function poke($times = 1)
    {
        for ($i = 0; $i < $times; $i++) {
            $this->queue->put($this->createRandomMessage());
        }
    }

    protected function createRandomMessage()
    {
        return rand(10000, 99999);
    }
}
