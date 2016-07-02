<?php

namespace App\Contracts\Mail;

interface Message
{
    /**
     * Add a new recipient to the email.
     *
     * @param string|Recipient $email
     * @param string           $name
     * @return self
     */
    public function addRecipient($email, $name = null);

    /**
     * Get all of the recipients.
     *
     * @return array
     */
    public function getRecipients();

    /**
     * Is there any recipient of this email?
     *
     * @return boolean
     */
    public function hasRecipients();

    /**
     * Set the subject of the mail.
     *
     * @param string $subject
     * @return self
     */
    public function setSubject($subject);

    /**
     * Get the subject of the mail.
     *
     * @return string
     */
    public function getSubject();

    /**
     * Set the content of the mail.
     *
     * @param string $text
     * @return self
     */
    public function setBody($text);

    /**
     * Get the content of the mail.
     *
     * @return string
     */
    public function getBody();
}
