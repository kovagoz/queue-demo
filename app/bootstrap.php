<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Container;
use App\Queue\QueueBuilder;
use PhpAmqpLib\Connection\AMQPStreamConnection;

setlocale(LC_ALL, 'hu_HU.UTF-8');

date_default_timezone_set('Europe/Budapest');

error_reporting(E_ALL);

ini_set('display_errors', 1);

$container = new Container;

$container->singleton('queue.channel', function ($c) {
    return (new AMQPStreamConnection('localhost', 5672, 'admin', 'almafa'))->channel();
});

// The primary job queue.
$container->singleton('queue', function ($c) {
    return (new QueueBuilder($c->make('queue.channel')))
        ->setName('demo')
        ->setDurable()
        ->setDeadLetterExchange($c->make('queue.sickbay'))
        ->getQueue();
});

// Dead Letter Exchange.
$container->singleton('queue.sickbay', function ($c) {
    return (new QueueBuilder($c->make('queue.channel')))
        ->setName('demo.sickbay')
        ->setDurable()
        ->setDeadLetterExchange('demo')
        ->setTimeout(1000)
        ->getQueue();
});
