<?php

use App\Mail\Message\PlainText as Message;
use App\Mail\Recipient;

class PlainTextMessageTest extends PHPUnit_Framework_TestCase
{
    public function testNewMessageHasNotRecipients()
    {
        $msg = new Message;

        $this->assertFalse($msg->hasRecipients());
        $this->assertCount(0, $msg->getRecipients());
    }

    public function testAddRecipient()
    {
        $msg = new Message;
        $msg->addRecipient('foo@example.com');

        $this->assertTrue($msg->hasRecipients());
        $this->assertCount(1, $msg->getRecipients());

        return $msg;
    }

    /**
     * @depends testAddRecipient
     */
    public function testRecipientsArePorperObjects($msg)
    {
        $this->assertContainsOnlyInstancesOf(Recipient::class, $msg->getRecipients());
    }

    public function testCannotAddSameRecipientTwice()
    {
        $msg = new Message;
        $msg->addRecipient('foo@example.com');
        $msg->addRecipient('foo@example.com');

        $this->assertCount(1, $msg->getRecipients());
    }
}
