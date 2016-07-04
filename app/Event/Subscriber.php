<?php

namespace App\Event;

abstract class Subscriber
{
    /**
     * Implement this method to subscribe to events.
     *
     * @param EventManager $events
     */
    abstract public function subscribe(EventManager $events);

    /**
     * For "callable" compatibility only.
     *
     * @param EventManager $events
     * @return void
     */
    public function __invoke($events)
    {
        $this->subscribe($events);
    }
}
