<?php

namespace App\Event;

use App\Contracts\Event\EventManager as EventManagerContract;
use InvalidArgumentException;

class EventManager implements EventManagerContract
{
    /**
     * @var array
     */
    protected $listeners = [];

    /**
     * Fire an event.
     *
     * @param mixed $event
     * @return void
     */
    public function fire($event)
    {
        if ($this->hasListeners($event)) {
            foreach ($this->getListeners($event) as $listener) {
                call_user_func($listener, $event);
            }
        }
    }

    /**
     * Register an event listener.
     *
     * @param string   $event
     * @param callable $callback
     * @return self
     */
    public function listen($event, callable $callback)
    {
        $this->listeners[$event][] = $callback;

        return $this;
    }

    /**
     * Get listeners to the given event.
     *
     * @param string $event
     * @return array
     */
    protected function getListeners($event)
    {
        $event = $this->getEventName($event);

        return $this->listeners[$event];
    }

    /**
     * Check if any listener has registered for the event.
     *
     * @param mixed $event
     * @return boolean
     */
    protected function hasListeners($event)
    {
        $event = $this->getEventName($event);

        return array_key_exists($event, $this->listeners);
    }

    /**
     * Get the name of the event.
     *
     * @param mixed $event
     * @return string
     */
    protected function getEventName($event)
    {
        if (is_object($event)) {
            return get_class($event);
        }

        if (is_string($event)) {
            return $event;
        }

        throw new InvalidArgumentException;
    }
}
