<?php

require_once __DIR__ . '/app/bootstrap.php';

use App\Queue\Message;

$container->make('queue')->listen(function (Message $message) {
    if (rand(0, 1)) {
        $message->reject();
        echo 'FAILED', PHP_EOL;
    } else {
        $message->done();
        echo '[x] ', $message->getPayload(), PHP_EOL;
    }
});
