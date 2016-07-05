<?php

namespace App\Domain\Events;

/**
 * Event fired before a new job is put into queue.
 */
class JobCreating extends JobEvent
{
    /**
     * Get log message.
     *
     * @return string
     */
    public function getLogMessage()
    {
        return "[{$this->payload}] New job has been created";
    }
}
