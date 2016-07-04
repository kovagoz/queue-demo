<?php

namespace App\Domain\Handlers;

use App\Contracts\Queue\Message;
use App\Contracts\Mail\Transport as Mailer;
use App\Contracts\Config\Repository as Config;
use App\Mail\Message\PlainText as Email;

class ErrorHandler extends Handler
{
    protected $mailer;

    protected $maxRetries = 3;

    protected $config;

    public function __construct(Mailer $mailer, Config $config)
    {
        $this->mailer = $mailer;
        $this->config = $config;
    }

    public function setMaxRetries($times)
    {
        $this->maxRetries = $times;
    }

    public function handle(Message $message)
    {
        if ($this->reachMaxRetries($message)) {
            $message->done();
            $this->reportFailure($message);
        }

        $message->reject();
    }

    protected function reportFailure(Message $message)
    {
        $mail = new Email;
        $mail->addRecipient($this->config['MAIL_TO']);
        $mail->setSubject($this->config['MAIL_SUBJECT']);
        $mail->setBody('Job failed with ID: ');

        $this->mailer->send($mail);
    }

    protected function reachMaxRetries(Message $message)
    {
        return $message->rejectCounter() >= $this->maxRetries - 1;
    }
}
