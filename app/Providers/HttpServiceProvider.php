<?php

namespace App\Providers;

use App\Contracts\Http\Request as RequestContract;
use App\Contracts\Http\Router as RouterContract;
use App\Contracts\Http\Dispatcher as DispatcherContract;
use App\Http\Router;
use App\Http\Request;
use App\Http\Dispatcher;

class HttpServiceProvider extends ServiceProvider
{
    /**
     * Register bindings.
     *
     * @return void
     */
    public function register()
    {
        $this->container->singleton(RequestContract::class, function () {
            return Request::createFromGlobals();
        });

        $this->container->alias(RequestContract::class, 'request');

        $this->container->singleton(RouterContract::class, function () {
            return new Router;
        });

        $this->container->alias(RouterContract::class, 'router');

        $this->container->bind(DispatcherContract::class, function ($c) {
            return new Dispatcher($c->make('router'), $c->make('app'));
        });

        $this->container->alias(DispatcherContract::class, 'http.dispatcher');
    }
}
