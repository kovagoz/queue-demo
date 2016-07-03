<?php

use App\Database\Platforms\Mysql\MysqlConfiguration;

class MysqlConfigurationTest extends PHPUnit_Framework_TestCase
{
    public function testDefaultHostAndPort()
    {
        $config = new MysqlConfiguration;

        $this->assertEquals('localhost', $config->getHost());
        $this->assertEquals(3306, $config->getPort());
    }

    public function testComposeDsn()
    {
        $config = new MysqlConfiguration;
        $config->setDatabase('foo');

        $expected_dsn = 'mysql:host=localhost;port=3306;dbname=foo';

        $this->assertEquals($expected_dsn, $config->getDsn());
    }

    public function testConvertToString()
    {
        $config = new MysqlConfiguration;
        $config->setDatabase('foo');

        $expected = 'mysql:host=localhost;port=3306;dbname=foo';

        $this->assertEquals($expected, (string) $config);
    }
}
