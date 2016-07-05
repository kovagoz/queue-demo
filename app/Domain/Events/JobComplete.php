<?php

namespace App\Domain\Events;

use Psr\Log\LogLevel;

class JobComplete extends JobEvent
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
        return "[{$this->payload}] Complete";
    }
}
