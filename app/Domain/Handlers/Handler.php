<?php

namespace App\Domain\Handlers;

use App\Contracts\Queue\MessageHandler;
use App\Contracts\Queue\Message;

abstract class Handler implements MessageHandler
{
    protected $successor;

    public function attach(Handler $handler)
    {
        if ($this->successor === null) {
            $this->successor = $handler;
        } else {
            $this->successor->setSuccessor($handler);
        }
    }

    protected function next(Message $message)
    {
        if ($this->successor !== null) {
            $this->successor->handle($message);
        }
    }
}
