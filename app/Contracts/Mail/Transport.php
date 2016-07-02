<?php

namespace App\Contracts\Mail;

interface Transport
{
    /**
     * Send an email.
     *
     * @param Message $message
     * @return void
     */
    public function send(Message $message);
}
