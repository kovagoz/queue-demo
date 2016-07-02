<?php

namespace App\Log\Exceptions;

use InvalidArgumentException;

class InvalidLogLevelException extends InvalidArgumentException
{
    /**
     * Create new exception.
     *
     * @param string $level
     */
    public function __construct($level)
    {
        parent::__construct("[{$level}] is an invalid log level");
    }
}
