<?php

namespace App\Domain;

use App\Event\Subscriber;
use App\Event\EventManager;
use App\Log\Logger;
use App\Contracts\Log\Loggable;

/**
 * Subscribe to queue events and log them.
 */
class EventLogger extends Subscriber
{
    /**
     * @var array
     */
    protected $events = [
        // Events\JobComplete::class,
        Events\JobCreated::class,
        // Events\JobFailed::class,
        // Events\JobRejected::class,
        // Events\JobReserved::class,
    ];

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * Create new event logger instance.
     *
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Subscribe to the queue events.
     *
     * @param EventManager $evm
     * @return void
     */
    public function subscribe(EventManager $evm)
    {
        foreach ($this->events as $event) {
            $evm->listen($event, function (Loggable $event) {
                $this->logger->log(
                    $event->getLogLevel(),
                    $event->getLogMessage()
                );
            });
        }
    }
}
