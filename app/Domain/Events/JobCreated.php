<?php

namespace App\Domain\Events;

use App\Contracts\Log\Loggable;
use Psr\Log\LogLevel;

/**
 * Event fired when a new job is put into queue.
 */
class JobCreated extends JobEvent implements Loggable
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
