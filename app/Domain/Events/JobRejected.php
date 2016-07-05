<?php

namespace App\Domain\Events;

use Psr\Log\LogLevel;

class JobRejected extends JobEvent
{
    /**
     * Get log level.
     *
     * @return string
     */
    public function getLogLevel()
    {
        return LogLevel::WARNING;
    }

    /**
     * Get log message.
     *
     * @return string
     */
    public function getLogMessage()
    {
        return "[{$this->payload}] Rejected";
    }
}
