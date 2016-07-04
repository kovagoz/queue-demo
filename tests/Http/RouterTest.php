<?php

use App\Http\Router;
use App\Contracts\Http\Request;
use Mockery as m;

class RouterTest extends PHPUnit_Framework_TestCase
{
    protected $router;

    public function setUp()
    {
        $this->router = new Router;

        $this->router->get('foo', function () {
            echo 'hello world';
        });

        $this->router->post('bar', function () {
            echo 'hello world';
        });
    }

    public function tearDown()
    {
        m::close();
    }

    public function testMatchGetRoute()
    {
        $request = m::mock(Request::class);
        $request->shouldReceive('getPath')->once()->andReturn('foo');
        $request->shouldReceive('getMethod')->once()->andReturn('GET');

        $this->assertInstanceOf(Closure::class, $this->router->match($request));
    }

    public function testMatchRouteStartedWithSlash()
    {
        $request = m::mock(Request::class);
        $request->shouldReceive('getPath')->once()->andReturn('/foo');
        $request->shouldReceive('getMethod')->once()->andReturn('GET');

        $this->assertInstanceOf(Closure::class, $this->router->match($request));
    }

    public function testMatchPostRoute()
    {
        $request = m::mock(Request::class);
        $request->shouldReceive('getPath')->once()->andReturn('bar');
        $request->shouldReceive('getMethod')->once()->andReturn('POST');

        $this->assertInstanceOf(Closure::class, $this->router->match($request));
    }

    /**
     * @expectedException App\Http\Exceptions\PageNotFoundException
     */
    public function testNoRoute()
    {
        $request = m::mock(Request::class);
        $request->shouldReceive('getPath')->andReturn('baz');
        $request->shouldReceive('getMethod')->andReturn('PUT');

        $this->router->match($request);
    }
}
