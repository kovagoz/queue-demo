<?php

namespace App\Mail\Exceptions;

use InvalidArgumentException;

class InvalidEmailException extends InvalidArgumentException
{
    /**
     * Create new exception.
     *
     * @param string $email_address
     */
    public function __construct($email_address)
    {
        parent::__construct("[{$email_address}] is not a valid email address");
    }
}
