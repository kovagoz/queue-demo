<?php

namespace App\Domain\Handlers;

use App\Contracts\Queue\MessageHandler;
use App\Contracts\Queue\Message;

abstract class Handler implements MessageHandler
{
    /**
     * @var MessageHandler
     */
    protected $successor;

    /**
     * Attach a new message handler to the end of the chain.
     *
     * @param Handler $handler
     * @return self
     */
    public function attach(Handler $handler)
    {
        if ($this->successor === null) {
            $this->successor = $handler;
        } else {
            $this->successor->setSuccessor($handler);
        }

        return $this;
    }

    /**
     * Call the next handler in the chain.
     *
     * @param Message $message
     * @return void
     */
    protected function next(Message $message)
    {
        if ($this->successor !== null) {
            $this->successor->handle($message);
        }
    }
}
