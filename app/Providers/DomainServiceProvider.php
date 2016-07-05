<?php

namespace App\Providers;

use App\Domain\MessageProcessor;
use App\Domain\MessageGenerator;
use App\Domain\Handlers\DefaultHandler;
use App\Domain\Handlers\ErrorHandler;
use App\Domain\EventLogger;

class DomainServiceProvider extends ServiceProvider
{
    /**
     * Do things after each provider have registered it's own bindings.
     *
     * @return void
     */
    public function boot()
    {
        // Initialize the queue event logger.
        $this->container->make('events')->subscribe(
            $this->container->make(EventLogger::class)
        );
    }

    /**
     * Register bindings.
     *
     * @return void
     */
    public function register()
    {
        $this->container->bind(ErrorHandler::class, function ($c) {
            return new ErrorHandler(
                $c->make('mail'),
                $c->make('config'),
                $c->make('events')
            );
        });

        $this->container->bind(MessageProcessor::class, function ($c) {
            $handler = new DefaultHandler($c->make('events'));
            $handler->attach($c->make(ErrorHandler::class));

            return new MessageProcessor($c->make('queue'), $handler);
        });

        $this->container->bind(MessageGenerator::class, function ($c) {
            return new MessageGenerator($c->make('queue'), $c->make('events'));
        });

        $this->container->singleton(EventLogger::class, function ($c) {
            return new EventLogger($c->make('log'));
        });
    }
}
