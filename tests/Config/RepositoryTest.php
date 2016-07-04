<?php

use App\Config\Repository as Config;

class RepositoryTest extends PHPUnit_Framework_TestCase
{
    public function testSetNewValue()
    {
        $config = new Config;
        $config['foo'] = 'bar';

        $this->assertEquals(['foo' => 'bar'], $config->dump());

        return $config;
    }

    /**
     * @depends testSetNewValue
     */
    public function testGetExistingValue($config)
    {
        $this->assertEquals('bar', $config['foo']);
    }

    public function testGetNonexistentValue()
    {
        $config = new Config;

        $this->assertNull($config['foo']);
    }

    /**
     * @depends testSetNewValue
     */
    public function testUpdateValue($config)
    {
        $config['foo'] = 'baz';

        $this->assertEquals('baz', $config['foo']);
    }

    /**
     * @depends testSetNewValue
     */
    public function testCheckValueExistence($config)
    {
        $this->assertTrue(isset($config['foo']));
        $this->assertFalse(isset($config['bar']));

        return $config;
    }

    /**
     * @depends testCheckValueExistence
     */
    public function testUnsetValue($config)
    {
        unset($config['foo']);

        $this->assertFalse(isset($config['foo']));
    }
}
