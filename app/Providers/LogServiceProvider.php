<?php

namespace App\Providers;

use App\Contracts\Log\Driver;
use App\Log\Logger;
use App\Log\Drivers\SyslogDriver;

class LogServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->container->bind(SyslogDriver::class, function () {
            return new SyslogDriver('app');
        });

        $this->container->bind(Driver::class, function ($c) {
            return new Logger($c->make(SyslogDriver::class));
        });

        $this->container->alias(Driver::class, 'log');
    }
}
