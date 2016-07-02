<?php

namespace App\Providers;

use App\Contracts\Event\EventManager as EventManagerContract;
use App\Event\EventManager;

class EventServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->container->singleton(EventManagerContract::class, function () {
            return new EventManager;
        });

        $this->container->alias(EventManagerContract::class, 'events');
    }
}
