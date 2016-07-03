<?php

use App\Contracts\Database\Connection;
use App\Log\Drivers\DatabaseDriver;
use Mockery as m;

class DatabaseDriverTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testSaveLogEntryToDatabase()
    {
        $params_validator = function ($params) {
            return in_array('notice', $params) && in_array('message', $params);
        };

        $db = m::mock(Connection::class);
        $db->shouldReceive('execute')
            ->with(m::type('string'), m::on($params_validator))
            ->once();

        $driver = new DatabaseDriver($db);
        $driver->log('notice', 'message');
    }
}
