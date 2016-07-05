<?php

namespace App\Domain\Events;

use App\Contracts\Log\Loggable;

/**
 * An abstraction for all queue events.
 */
abstract class JobEvent implements Loggable
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
