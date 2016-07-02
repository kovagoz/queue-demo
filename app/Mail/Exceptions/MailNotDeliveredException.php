<?php

namespace App\Mail\Exceptions;

use App\Contracts\Mail\Message;
use RuntimeException;

class MailNotDeliveredException extends RuntimeException
{
    /**
     * Create new exception.
     *
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        parent::__construct('Mail cannot be sent');
    }
}
