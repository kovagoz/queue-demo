<?php

namespace App\Contracts\Log;

interface Driver
{
    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     * @return void
     */
    public function log($level, $message);
}
