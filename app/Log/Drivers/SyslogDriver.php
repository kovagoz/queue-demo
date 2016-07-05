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
     * Relationship between the log levels of the two system.
     *
     * @var array
     */
    protected $dictionary = [
        LogLevel::EMERGENCY => LOG_EMERG,
        LogLevel::ALERT     => LOG_ALERT,
        LogLevel::CRITICAL  => LOG_CRIT,
        LogLevel::ERROR     => LOG_ERR,
        LogLevel::WARNING   => LOG_WARNING,
        LogLevel::NOTICE    => LOG_NOTICE,
        LogLevel::INFO      => LOG_INFO,
        LogLevel::DEBUG     => LOG_DEBUG
    ];

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
     * @throws InvalidLogLevelException
     */
    protected function getPriority($level)
    {
        if (array_key_exists($level, $this->dictionary)) {
            return $this->dictionary[$level];
        }

        throw new InvalidLogLevelException($level);
    }
}
