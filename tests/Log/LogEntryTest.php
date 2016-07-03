<?php

use App\Contracts\Database\Connection;
use App\Log\Drivers\Database\LogEntry;
use Mockery as m;

class LogEntryTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testSaveLogEntryWithDefaultLogLevel()
    {
        $params_validator = function ($params) {
            return in_array('notice', $params) && in_array('message', $params);
        };

        $db = m::mock(Connection::class);
        $db->shouldReceive('execute')
            ->with(m::type('string'), m::on($params_validator))
            ->once();

        $entry = new LogEntry('message');
        $entry->save($db);
    }

    public function testSaveLogEntryWithLogLevelSpecified()
    {
        $params_validator = function ($params) {
            return in_array('warning', $params) && in_array('message', $params);
        };

        $db = m::mock(Connection::class);
        $db->shouldReceive('execute')
            ->with(m::type('string'), m::on($params_validator))
            ->once();

        $entry = new LogEntry('message', 'warning');
        $entry->save($db);
    }
}
