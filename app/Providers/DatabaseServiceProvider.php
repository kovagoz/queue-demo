<?php

namespace App\Providers;

use App\Contracts\Database\Connection;
use App\Database\Drivers\PdoMysql\PdoMysqlConnection;
use App\Database\Platforms\Mysql\MysqlConfiguration;

class DatabaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->container->bind(MysqlConfiguration::class, function ($c) {
            $config = $c->make('config');

            return (new MysqlConfiguration)
                ->setHost($config['DB_HOST'])
                ->setPort($config['DB_PORT'])
                ->setUsername($config['DB_USER'])
                ->setPassword($config['DB_PASS'])
                ->setDatabase($config['DB_NAME']);
        });

        $this->container->singleton(Connection::class, function ($c) {
            return new PdoMysqlConnection(
                $c->make(MysqlConfiguration::class)
            );
        });

        $this->container->alias(Connection::class, 'db');
    }
}
