<?php

use App\Log\Drivers\SyslogDriver;

class SyslogDriverTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException App\Log\Exceptions\InvalidLogLevelException
     */
    public function testUseInvalidLogLevel()
    {
        $driver = new SyslogDriver('test');
        $driver->log('invalid level', 'message');
    }
}
