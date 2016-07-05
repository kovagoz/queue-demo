<?php

namespace App\Contracts\Queue;

interface Message
{
    /**
     * Get the raw message from the message object.
     *
     * @return mixed
     */
    public function getPayload();

    /**
     * Mark the message successfully processed.
     *
     * @return void
     */
    public function done();

    /**
     * Reject the message.
     *
     * @return void
     */
    public function reject();

    /**
     * Get the number of times message was rejected.
     *
     * @return integer
     */
    public function rejectCounter();
}
