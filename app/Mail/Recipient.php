<?php

namespace App\Mail;

use App\Mail\Exceptions\InvalidEmailException;

/**
 * A recipient of an email.
 */
class Recipient
{
    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $name;

    /**
     * Create new recipient instance.
     *
     * @param string $email
     * @param string $name
     */
    public function __construct($email, $name = null)
    {
        $this->setEmail($email);
        $this->setName($name);
    }

    /**
     * Set the email address.
     *
     * @param string $email
     * @return self
     * @throws InvalidEmailException
     */
    public function setEmail($email)
    {
        if (!$this->isValidEmail($email)) {
            throw new InvalidEmailException($email);
        }

        $this->email = $email;

        return $this;
    }

    /**
     * Get the email address.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set recipient's name.
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get recipient's name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Check if recipient's name is set.
     *
     * @return boolean
     */
    public function hasName()
    {
        return !empty($this->name);
    }

    /**
     * Convert recipient to RFC822 format.
     *
     * @return string
     */
    public function __toString()
    {
        if (!$this->hasName()) {
            return $this->email;
        }

        return sprintf('%s <%s>', $this->getName(), $this->getEmail());
    }

    /**
     * Check if the given email address is valid.
     *
     * @param string $email
     * @return boolean
     */
    protected function isValidEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}
