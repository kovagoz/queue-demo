<?php

namespace App\Providers;

use App\Contracts\Log\Driver;
use App\Log\Logger;
use App\Log\Drivers\SyslogDriver;
use App\Log\Drivers\DatabaseDriver;
use App\Log\Drivers\Database\LogEntryRepository;

class LogServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->container->bind(SyslogDriver::class, function () {
            return new SyslogDriver('app');
        });

        $this->container->bind(DatabaseDriver::class, function ($c) {
            return new DatabaseDriver($c->make('db'));
        });

        $this->container->bind(Driver::class, function ($c) {
            return new Logger($c->make(DatabaseDriver::class));
        });

        $this->container->alias(Driver::class, 'log');

        $this->container->singleton(LogEntryRepository::class, function ($c) {
            return new LogEntryRepository($c->make('db'));
        });

        $this->container->alias(LogEntryRepository::class, 'audit');
    }
}
