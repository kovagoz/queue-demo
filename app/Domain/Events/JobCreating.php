<?php

namespace App\Domain\Events;

use Psr\Log\LogLevel;

/**
 * Event fired before a new job is put into queue.
 */
class JobCreating extends JobEvent
{
    /**
     * Get log level.
     *
     * @return string
     */
    public function getLogLevel()
    {
        return LogLevel::NOTICE;
    }

    /**
     * Get log message.
     *
     * @return string
     */
    public function getLogMessage()
    {
        return "Create new job with ID: {$this->payload}";
    }
}
