<?php

namespace App\Providers;

use App\Queue\QueueBuilder;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class QueueServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->container->singleton('queue.channel', function ($c) {
            return (new AMQPStreamConnection('localhost', 5672, 'admin', 'almafa'))->channel();
        });

        // The primary job queue.
        $this->container->singleton('queue', function ($c) {
            return (new QueueBuilder($c->make('queue.channel')))
                ->setName('demo')
                ->setDurable()
                ->setDeadLetterExchange($c->make('queue.sickbay'))
                ->getQueue();
        });

        // Dead Letter Exchange.
        $this->container->singleton('queue.sickbay', function ($c) {
            return (new QueueBuilder($c->make('queue.channel')))
                ->setName('demo.sickbay')
                ->setDurable()
                ->setDeadLetterExchange('demo')
                ->setTimeout(1000)
                ->getQueue();
        });
    }
}
