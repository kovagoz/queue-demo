<?php

namespace App\Domain\Handlers;

use App\Contracts\Queue\Message;
use App\Contracts\Mail\Transport as Mailer;
use App\Contracts\Config\Repository as Config;
use App\Contracts\Event\EventManager;
use App\Mail\Message\PlainText as Email;
use App\Domain\Events\JobFailed;
use App\Domain\Events\JobRejected;

class ErrorHandler extends Handler
{
    protected $mailer;

    protected $maxRetries = 3;

    protected $config;

    protected $events;

    public function __construct(Mailer $mailer, Config $config, EventManager $events)
    {
        $this->mailer = $mailer;
        $this->config = $config;
        $this->events = $events;
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

            $this->events->fire(new JobFailed($message->getPayload()));
        } else {
            $message->reject();

            $this->events->fire(new JobRejected($message->getPayload()));
        }
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
