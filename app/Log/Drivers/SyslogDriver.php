<?php

namespace App\Log\Drivers;

use App\Contracts\Log\Driver;
use App\Log\Exceptions\InvalidLogLevelException;
use Psr\Log\LogLevel;

/**
 * A simple syslog driver just for fun.
 */
class SyslogDriver implements Driver
{
    /**
     * Create new syslog driver instance.
     *
     * @param string $ident The string ident is added to each message.
     */
    public function __construct($ident)
    {
        openlog($ident, LOG_PID, LOG_LOCAL0);
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     * @return void
     */
    public function log($level, $message)
    {
        syslog($this->getPriority($level), (string) $message);
    }

    /**
     * Convert a PSR log level to the corresponding syslog value.
     *
     * @param string $level
     * @return integer
     */
    protected function getPriority($level)
    {
        switch ($level) {
            case LogLevel::EMERGENCY:
                return LOG_EMERG;

            case LogLevel::ALERT:
                return LOG_ALERT;

            case LogLevel::CRITICAL:
                return LOG_CRIT;

            case LogLevel::ERROR:
                return LOG_ERR;

            case LogLevel::WARNING:
                return LOG_WARNING;

            case LogLevel::NOTICE:
                return LOG_NOTICE;

            case LogLevel::INFO:
                return LOG_INFO;

            case LogLevel::DEBUG:
                return LOG_DEBUG;

            default:
                throw new InvalidLogLevelException($level);
        }
    }
}
