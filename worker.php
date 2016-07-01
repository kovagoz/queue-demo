<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('localhost', 5672, 'admin', 'almafa');

$channel = $connection->channel();

$channel->queue_declare('demo', false, false, false, false);

echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

$callback = function($msg) {
    echo 'Working...';
    sleep(($msg->body % 2) * 4);
    echo 'done', PHP_EOL;
    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
};

$channel->basic_qos(null, 1, null);
$channel->basic_consume('demo', '', false, false, false, false, $callback);

while (count($channel->callbacks)) {
    $channel->wait();
}
