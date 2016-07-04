<?php

namespace App\Domain\Events;

/**
 * An abstraction for all queue events.
 */
abstract class JobEvent
{
    /**
     * @var mixed
     */
    public $payload;

    /**
     * Create new job event.
     *
     * @param mixed $payload
     */
    public function __construct($payload)
    {
        $this->payload = $payload;
    }
}
