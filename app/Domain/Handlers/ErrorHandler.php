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
    /**
     * @var Mailer
     */
    protected $mailer;

    /**
     * @var integer
     */
    protected $maxTries = 3;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var EventManager
     */
    protected $events;

    /**
     * Create new error handler instance.
     *
     * @param Mailer       $mailer
     * @param Config       $config
     * @param EventManager $events
     */
    public function __construct(
        Mailer $mailer,
        Config $config,
        EventManager $events
    ) {
        $this->mailer = $mailer;
        $this->config = $config;
        $this->events = $events;
    }

    /**
     * Set the maximum number of tries to process a message.
     *
     * @param integer $times
     * @return self
     */
    public function setMaxTries($times)
    {
        $this->maxTries = $times;

        return $this;
    }

    /**
     * Decide what happens with the message from a failed processing.
     *
     * @param Message $message
     * @return void
     */
    public function handle(Message $message)
    {
        if ($this->reachMaxTries($message)) {
            // Remove message from the queue.
            $message->done();
            $this->reportFailure($message);
            $this->events->fire(new JobFailed($message->getPayload()));
        } else {
            $message->reject();
            $this->events->fire(new JobRejected($message->getPayload()));
        }
    }

    /**
     * Send an email about the failure.
     *
     * @param Message $message
     * @return void
     */
    protected function reportFailure(Message $message)
    {
        $mail = new Email;
        $mail->addRecipient($this->config['MAIL_TO']);
        $mail->setSubject($this->config['MAIL_SUBJECT']);
        $mail->setBody("Cannot process message [{$message->getPaylod()}].");

        $this->mailer->send($mail);
    }

    /**
     * Check if message has reached the maximum number of tries.
     *
     * @param Message $message
     * @return boolean
     */
    protected function reachMaxTries(Message $message)
    {
        return $message->rejectCounter() >= $this->maxTries - 1;
    }
}
