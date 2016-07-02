<?php

namespace App\Event;

abstract class Listener
{
    /**
     * Handle the event.
     *
     * @param mixed $event
     * @return void
     */
    abstract public function handle($event);

    /**
     * Make the event listener callable.
     *
     * EventManager accepts only callable entities as listeners.
     *
     * @param mixed $event
     * @return void
     */
    public function __invoke($event)
    {
        $this->handle($event);
    }
}
