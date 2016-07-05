<?php

namespace App\Domain;

use App\Contracts\Queue\Queue;
use App\Contracts\Event\EventManager;

class MessageGenerator
{
    /**
     * @var Queue
     */
    protected $queue;

    /**
     * @var EventManager
     */
    protected $events;

    /**
     * Create new message generator instance.
     *
     * @param Queue        $queue
     * @param EventManager $events
     */
    public function __construct(Queue $queue, EventManager $events)
    {
        $this->queue  = $queue;
        $this->events = $events;
    }

    /**
     * Put a new message to the queue.
     *
     * @return void
     */
    public function publish()
    {
        $message = $this->createRandomMessage();

        $this->queue->put($message);

        $this->events->fire(new Events\JobCreated($message));
    }

    /**
     * Create a random message.
     *
     * @return integer
     */
    protected function createRandomMessage()
    {
        return rand(10000, 99999);
    }
}
