<?php

namespace App\Domain\Handlers;

use App\Contracts\Queue\Message;
use App\Contracts\Event\EventManager;
use App\Domain\Events\JobComplete;
use App\Domain\Events\JobReserved;

/**
 * This handler do the work.
 */
class DefaultHandler extends Handler
{
    /**
     * @var EventManager
     */
    protected $events;

    /**
     * Create new instance.
     *
     * @param EventManager $events
     */
    public function __construct(EventManager $events)
    {
        $this->events = $events;
    }

    /**
     * Process the given message.
     *
     * @param Message $message
     * @return mixed
     */
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

    /**
     * Get the success of the message processing.
     *
     * @return boolean
     */
    protected function fails()
    {
        return (bool) rand(0, 3);
    }
}
