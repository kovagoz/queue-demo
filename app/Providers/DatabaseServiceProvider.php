<?php

namespace App\Providers;

use App\Contracts\Database\Connection;
use App\Database\Drivers\PdoMysql\PdoMysqlConnection;
use App\Database\Platforms\Mysql\MysqlConfiguration;

class DatabaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->container->bind(MysqlConfiguration::class, function () {
            return (new MysqlConfiguration)
                ->setDatabase('demo');
        });

        $this->container->singleton(Connection::class, function ($c) {
            return new PdoMysqlConnection(
                $c->make(MysqlConfiguration::class)
            );
        });

        $this->container->alias(Connection::class, 'db');
    }
}
