<?php

require __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'admin', 'almafa');

$channel = $connection->channel();

$channel->queue_declare('demo', false, false, false, false);

for ($i = 1; $i < 10; $i++) {
    $msg = new AMQPMessage($i);
    $channel->basic_publish($msg, '', 'demo');
}

$channel->close();

$connection->close();
