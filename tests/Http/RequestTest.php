<?php

use App\Http\Request;

class RequestTest extends PHPUnit_Framework_TestCase
{
    public function testDefaultMethodIsGet()
    {
        $request = new Request('http://example.com/');

        $this->assertEquals('GET', $request->getMethod());
    }

    /**
     * @dataProvider methodProvider
     */
    public function testSetMethod($method, $expected)
    {
        $request = new Request('http://example.com/', $method);

        $this->assertEquals($expected, $request->getMethod());
    }

    public function methodProvider()
    {
        return [
            ['post', 'POST'],
            ['GET', 'GET'],
            [null, 'GET'],
        ];
    }

    public function testHasParam()
    {
        $request = new Request('http://example.com/?foo=bar');

        $this->assertTrue($request->hasParam('foo'));
        $this->assertFalse($request->hasParam('bar'));
    }

    /**
     * @dataProvider paramProvider
     */
    public function testGetParam($param, $expected)
    {
        $request = new Request('http://example.com/?foo=bar');

        $this->assertEquals($expected, $request->getParam($param));
    }

    public function paramProvider()
    {
        return [
            ['foo', 'bar'],
            ['bar', null],
        ];
    }
}
