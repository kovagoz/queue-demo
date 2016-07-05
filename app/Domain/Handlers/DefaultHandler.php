<?php

namespace App\Domain\Handlers;

use App\Contracts\Queue\Message;
use App\Contracts\Event\EventManager;
use App\Domain\Events\JobComplete;
use App\Domain\Events\JobReserved;

class DefaultHandler extends Handler
{
    protected $events;

    public function __construct(EventManager $events)
    {
        $this->events = $events;
    }

    public function handle(Message $message)
    {
        // $this->events->fire(new JobReserved($message->getPayload()));

        // Do something...

        if ($this->fails()) {
            return $this->next($message);
        }

        $message->done();

        $this->events->fire(new JobComplete($message->getPayload()));
    }

    protected function fails()
    {
        return (bool) rand(0, 3);
    }
}
