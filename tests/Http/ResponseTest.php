<?php

namespace App\Http;

use App\Http\Response;
use Mockery as m;
use PHPUnit_Framework_TestCase;

function http_response_code($code)
{
    return ResponseTest::$functions->http_response_code($code);
}

function header($value)
{
    return ResponseTest::$functions->header($value);
}

class ResponseTest extends PHPUnit_Framework_TestCase
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

    public function testPlainTextResponse()
    {
        $response = new Response('hello world');

        self::$functions->shouldReceive('http_response_code')->once()->with(200);

        ob_start();

        $response->send();

        $this->assertEquals('hello world', ob_get_clean());
    }

    public function testEmptyResponse()
    {
        $response = new Response;

        self::$functions->shouldReceive('http_response_code')->once()->with(204);

        ob_start();

        $response->send();

        $this->assertEquals(null, ob_get_clean());

        return $response;
    }

    public function testChangeStatusCode()
    {
        $response = new Response;
        $response->setStatus(400);

        self::$functions->shouldReceive('http_response_code')->once()->with(400);

        $response->send();
    }

    public function testSetHeaders()
    {
        $response = new Response;
        $response->setHeader('Content-Type', 'text/html');

        self::$functions->shouldReceive('http_response_code')->once()->with(204);
        self::$functions->shouldReceive('header')->once()->with('Content-Type: text/html');

        $response->send();
    }

    public function testJsonResponse()
    {
        $response = new Response(['foo' => 'bar']);

        self::$functions->shouldReceive('http_response_code')->once()->with(200);
        self::$functions->shouldReceive('header')->once()->with('Content-Type: application/json');

        ob_start();

        $response->send();

        $this->assertEquals('{"foo":"bar"}', ob_get_clean());
    }
}
