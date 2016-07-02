<?php

namespace App\Contracts\Event;

interface EventManager
{
    /**
     * Fire an event.
     *
     * @param mixed $event
     * @return void
     */
    public function fire($event);

    /**
     * Register an event listener.
     *
     * @param string   $event
     * @param callable $callback
     * @return self
     */
    public function listen($event, callable $callback);
}
