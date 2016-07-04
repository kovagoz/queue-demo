<?php

namespace App\Providers;

use App\Http\Request;
use App\Http\Dispatcher;

class HttpServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->singleton(Request::class, function () {
            return Request::createFromGlobals();
        });

        $this->alias(Request::class, 'request');

        $this->bind(Dispatcher::class, function ($c) {
            return new Dispatcher($c->make('request'), $c->make('app'));
        });
    }
}
