<?php

namespace App\Log;

use App\Contracts\Log\Driver;
use Psr\Log\AbstractLogger;

/**
 * PSR-3 logger implementation.
 *
 * @see http://www.php-fig.org/psr/psr-3/
 */
class Logger extends AbstractLogger
{
    /**
     * @var Driver
     */
    protected $driver;

    /**
     * Create new logger instance.
     *
     * @param Driver $driver
     */
    public function __construct(Driver $driver)
    {
        $this->driver = $driver;
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     * @return void
     */
    public function log($level, $message, array $context = [])
    {
        $this->driver->log($level, $message);
    }

    /**
     * Set the logger driver.
     *
     * @param Driver $driver
     * @return self
     */
    public function setDriver(Driver $driver)
    {
        $this->driver = $driver;

        return $this;
    }
}
