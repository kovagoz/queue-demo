<?php

namespace App\Domain\Handlers;

use App\Contracts\Queue\Message;

class DefaultHandler extends Handler
{
    public function handle(Message $message)
    {
        // Do something...

        if ($this->fails()) {
            return $this->successor->handle($message);
        }
    }

    protected function fails()
    {
        return (bool) rand(0, 3);
    }
}
