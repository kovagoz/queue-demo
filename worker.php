<?php

require_once __DIR__ . '/app/bootstrap.php';

use App\Queue\Message;

$container->make('queue')->listen(function (Message $message) {
    echo '[x] ', $message->payload, PHP_EOL;
});
