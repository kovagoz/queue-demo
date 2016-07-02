<?php

namespace App\Mail\Message;

use App\Contracts\Mail\Message;
use App\Mail\Recipient;

/**
 * Plain text email message.
 */
class PlainText implements Message
{
    /**
     * @var array
     */
    protected $recipients = [];

    /**
     * @var string
     */
    protected $subject;

    /**
     * @var string
     */
    protected $body;

    /**
     * Add a new recipient to the email.
     *
     * @param string|Recipient $email
     * @param string           $name
     * @return self
     */
    public function addRecipient($email, $name = null)
    {
        $this->addRecipientInstance(
            is_string($email) ? new Recipient($email, $name) : $email
        );

        return $this;
    }

    /**
     * Get all of the recipients.
     *
     * @return array
     */
    public function getRecipients()
    {
        return $this->recipients;
    }

    /**
     * Is there any recipient of this email?
     *
     * @return boolean
     */
    public function hasRecipients()
    {
        return count($this->recipients) > 0;
    }

    /**
     * Set the subject of the mail.
     *
     * @param string $subject
     * @return self
     */
    public function setSubject($subject)
    {
        $this->subject = trim($subject);

        return $this;
    }

    /**
     * Get the subject of the mail.
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set the content of the mail.
     *
     * @param string $text
     * @return self
     */
    public function setBody($text)
    {
        $this->body = $text;

        return $this;
    }

    /**
     * Get the content of the mail.
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Check that email has already added to the recipients.
     *
     * @param string $email
     * @return boolean
     */
    protected function isAddressedTo($email)
    {
        if ($email instanceof Recipient) {
            $email = $email->getEmail();
        }

        foreach ($this->recipients as $recipient) {
            if ($recipient->getEmail() === $email) {
                return true;
            }
        }

        return false;
    }

    /**
     * Assign a Recipient object to the mail.
     *
     * @param Recipient $recipient
     * @return void
     */
    protected function addRecipientInstance(Recipient $recipient)
    {
        if (!$this->isAddressedTo($recipient)) {
            $this->recipients[] = $recipient;
        }
    }
}
