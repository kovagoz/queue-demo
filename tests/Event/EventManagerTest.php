<?php

use App\Event\EventManager;
use App\Event\Listener;
use Mockery as m;

class EventManagerTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testClosureListener()
    {
        $result = null;

        $listener = function ($event) use (&$result) {
            $result = $event;
        };

        (new EventManager)
            ->listen('foo', $listener)
            ->fire('foo');

        $this->assertEquals('foo', $result);
    }

    public function testObjectListener()
    {
        $listener = m::mock(Listener::class . '[handle]');
        $listener->shouldReceive('handle')->once()->with('foo');

        (new EventManager)
            ->listen('foo', $listener)
            ->fire('foo');
    }

    public function testMultipleListeners()
    {
        $result = 0;

        $listener = function ($event) use (&$result) {
            $result++;
        };

        (new EventManager)
            ->listen('foo', $listener)
            ->listen('foo', $listener)
            ->fire('foo');

        $this->assertEquals(2, $result);
    }

    public function testOtherEventDoesNotAffectListener()
    {
        $result = 0;

        $listener = function ($event) use (&$result) {
            $result++;
        };

        (new EventManager)
            ->listen('foo', $listener)
            ->fire('bar');

        $this->assertEquals(0, $result);
    }
}
