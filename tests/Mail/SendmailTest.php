<?php

namespace App\Mail\Transport;

use App\Mail\Message\PlainText as Message;
use App\Mail\Transport\Sendmail;
use Mockery as m;

/**
 * Mocking the mail() function.
 *
 * @see https://laracasts.com/discuss/channels/testing/i-need-to-mock-a-php-function/replies/16462
 */
function mail()
{
    return SendmailTest::$functions->mail();
}

class SendmailTest extends \PHPUnit_Framework_TestCase
{
    public static $functions;

    public function setUp()
    {
        self::$functions = m::mock();
    }

    public function tearDown()
    {
        m::close();
    }

    /**
     * @expectedException App\Mail\Exceptions\NoRecipientException
     */
    public function testTrySendMailWithoutRecipients()
    {
        $sendmail = new Sendmail;
        $sendmail->send(new Message);
    }

    /**
     * @expectedException App\Mail\Exceptions\MailNotDeliveredException
     */
    public function testDeliveryFailed()
    {
        $msg = new Message;
        $msg->addRecipient('foo@example.com');

        self::$functions->shouldReceive('mail')->once()->andReturn(false);

        $sendmail = new Sendmail;
        $sendmail->send($msg);
    }
}
