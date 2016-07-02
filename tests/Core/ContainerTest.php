<?php

use App\Core\Container;

class ContainerTest extends PHPUnit_Framework_TestCase
{
    public function testResolveExistingBinding()
    {
        $container = new Container;

        $container->bind('foo', function () {
            return new stdClass;
        });

        $this->assertInstanceOf(stdClass::class, $container->make('foo'));
    }

    public function testResolvingTwiceProduceDifferentInstances()
    {
        $container = new Container;

        $container->bind('foo', function () {
            return new stdClass;
        });

        $first_instance = $container->make('foo');

        $this->assertNotSame($first_instance, $container->make('foo'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testResolvingNonexistentBinding()
    {
        $container = new Container;

        $container->make('foo');
    }

    /**
     * @dataProvider singletonProvider
     */
    public function testResolvingSingleton($singleton)
    {
        $container = new Container;

        $container->singleton('foo', function () use ($singleton) {
            return $singleton;
        });

        $first_instance = $container->make('foo');

        $this->assertSame($first_instance, $container->make('foo'));
    }

    public function singletonProvider()
    {
        return [
            [new stdClass],
            [function () {}]
        ];
    }

    /**
     * @dataProvider instanceProvider
     */
    public function testBindInstance($instance)
    {
        $container = new Container;

        $container->instance('foo', $instance);

        $this->assertSame($instance, $container->make('foo'));
    }

    public function instanceProvider()
    {
        return [
            [new stdClass],
            [function () {}]
        ];
    }

    public function testUseAlias()
    {
        $container = new Container;

        $container->bind('foo', function () {
            return new stdClass;
        });

        $container->alias('foo', 'bar');

        $this->assertEquals(
            $container->make('foo'),
            $container->make('bar')
        );
    }
}
