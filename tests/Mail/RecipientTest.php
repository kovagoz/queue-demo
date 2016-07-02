<?php

use App\Mail\Recipient;

class RecipientTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException App\Mail\Exceptions\InvalidEmailException
     */
    public function testContructWithInvalidEmail()
    {
        $recipient = new Recipient('foo');
    }

    public function testConstructWithoutName()
    {
        $recipient = new Recipient('foo@example.com');

        $this->assertFalse($recipient->hasName());

        return $recipient;
    }

    /**
     * @depends testConstructWithoutName
     */
    public function testSetName($recipient)
    {
        $name = 'John Doe';

        $recipient->setName($name);

        $this->assertTrue($recipient->hasName());
        $this->assertEquals($name, $recipient->getName());
    }

    /**
     * @depends testConstructWithoutName
     */
    public function testGetEmailAddress($recipient)
    {
        $this->assertEquals('foo@example.com', $recipient->getEmail());
    }

    public function testConvertToStringWithoutName()
    {
        $recipient = new Recipient('foo@example.com');

        $this->assertEquals($recipient->getEmail(), (string) $recipient);
    }

    public function testConvertToStringWithName()
    {
        $recipient = new Recipient('foo@example.com', 'John Doe');

        $this->assertEquals('John Doe <foo@example.com>', (string) $recipient);
    }
}
