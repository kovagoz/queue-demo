<?php

namespace App\Providers;

use App\Domain\MessageProcessor;
use App\Domain\Handlers\ErrorHandler;

class DomainServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->bind(ErrorHandler::class, function ($c) {
            return new ErrorHandler($c->make('mail'), $c->make('config'));
        });

        $this->bind(MessageProcessor::class, function ($c) {
            $handler = new DefaultHandler;
            $handler->attach($c->make(ErrorHandler::class));

            return new MessageProcessor($c->make('queue'), $handler);
        });

        $this->bind(MessageGenerator::class, function ($c) {
            return new MessageGenerator($c->make('queue'));
        });
    }
}
