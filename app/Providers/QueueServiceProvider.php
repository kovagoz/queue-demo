<?php

namespace App\Providers;

use App\Queue\Drivers\Amqp\QueueBuilder;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class QueueServiceProvider extends ServiceProvider
{
    /**
     * Register bindings.
     *
     * @return void
     */
    public function register()
    {
        $this->container->singleton('queue.channel', function ($c) {
            $config = $c->make('config');

            $connection = new AMQPStreamConnection(
                $config['AMQP_HOST'],
                $config['AMQP_PORT'],
                $config['AMQP_USER'],
                $config['AMQP_PASS']
            );

            return $connection->channel();
        });

        // The primary job queue.
        $this->container->singleton('queue', function ($c) {
            $config = $c->make('config');

            return (new QueueBuilder($c->make('queue.channel')))
                ->setName($config['AMQP_QUEUE'])
                ->setDurable()
                ->setDeadLetterExchange($c->make('queue.sickbay'))
                ->getQueue();
        });

        // Dead Letter Exchange.
        $this->container->singleton('queue.sickbay', function ($c) {
            $config = $c->make('config');

            return (new QueueBuilder($c->make('queue.channel')))
                ->setName("{$config['AMQP_QUEUE']}.sickbay")
                ->setDurable()
                ->setDeadLetterExchange($config['AMQP_QUEUE'])
                ->setTimeout(1000)
                ->getQueue();
        });
    }
}
