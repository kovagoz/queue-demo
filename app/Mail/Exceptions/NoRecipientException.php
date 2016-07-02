<?php

namespace App\Mail\Exceptions;

use InvalidArgumentException;

class NoRecipientException extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Email has not any recipient');
    }
}
