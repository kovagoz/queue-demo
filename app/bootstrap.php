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

$container->singleton('queue', function ($c) {
    $channel = (new AMQPStreamConnection('localhost', 5672, 'admin', 'almafa'))->channel();

    return (new QueueBuilder($channel))
        ->setName('demo')
        ->setDurable()
        ->getQueue();
});
