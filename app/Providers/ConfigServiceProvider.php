<?php

namespace App\Providers;

use App\Contracts\Config\Repository as Config;
use App\Config\Repository;

class ConfigServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->container->singleton(Config::class, function () {
            return new Repository(
                parse_ini_file(__DIR__ . '/../../config.ini');
            );
        });

        $this->container->alias(Config::class, 'config');
    }
}
