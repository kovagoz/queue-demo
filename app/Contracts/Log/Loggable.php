<?php

namespace App\Contracts\Log;

interface Loggable
{
    /**
     * Get the logging level.
     *
     * @return string
     */
    public function getLogLevel();

    /**
     * Get the log message.
     *
     * @return string
     */
    public function getLogMessage();
}
