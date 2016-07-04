<?php

namespace App\Domain\Handlers;

use App\Contracts\Queue\Message;
use App\Contracts\Mail\Transport as Mailer;

class ErrorHandler extends Handler
{
    protected $mailer;

    protected $maxRetries = 3;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function setMaxRetries($times)
    {
        $this->maxRetries = $times;
    }

    public function handle(Message $message)
    {
        if ($message->rejectCounter() >= $this->maxRetries) {
            $this->mailer->send($mail);
        }

        return false;
    }
}
