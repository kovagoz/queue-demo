<?php

namespace App\Mail\Exceptions;

use InvalidArgumentException;

class NoRecipientException extends InvalidArgumentException
{
    /**
     * Create new exception.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct('Email has not any recipient');
    }
}
