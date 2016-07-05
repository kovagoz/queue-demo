<?php

namespace App\Domain\Events;

use Psr\Log\LogLevel;

class JobFailed extends JobEvent
{
    /**
     * Get log level.
     *
     * @return string
     */
    public function getLogLevel()
    {
        return LogLevel::ERROR;
    }

    /**
     * Get log message.
     *
     * @return string
     */
    public function getLogMessage()
    {
        return "[{$this->payload}] Failed";
    }
}
