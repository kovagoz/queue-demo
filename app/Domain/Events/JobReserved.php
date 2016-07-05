<?php

namespace App\Domain\Events;

class JobReserved extends JobEvent
{
    /**
     * Get log message.
     *
     * @return string
     */
    public function getLogMessage()
    {
        return "[{$this->payload}] Reserved";
    }
}
