<?php

namespace App\Mail\Transport;

use App\Contracts\Mail\Message;
use App\Contracts\Mail\Transport;
use App\Mail\Exceptions\NoRecipientException;
use App\Mail\Exceptions\MailNotDeliveredException;

/**
 * Sendmail transport layer.
 */
class Sendmail implements Transport
{
    /**
     * Send an email.
     *
     * @param Message $message
     * @return void
     */
    public function send(Message $message)
    {
        $is_delivered = mail(
            $this->formatRecipients($message),
            $message->getSubject(),
            $message->getBody()
        );

        if (!$is_delivered) {
            throw new MailNotDeliveredException($message);
        }
    }

    /**
     * Create a recipient string accepted by PHP's mail() function.
     *
     * @param Message $message
     * @return string
     */
    protected function formatRecipients(Message $message)
    {
        if (!$message->hasRecipients()) {
            throw new NoRecipientException;
        }

        return implode(',', array_map('strval', $message->getRecipients()));
    }
}
