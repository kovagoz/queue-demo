<?php

require_once __DIR__ . '/app/bootstrap.php';

use App\Queue\Message;

$app('queue')->listen(function (Message $message) {
    if (rand(0, 3)) {
        echo 'FAILED', PHP_EOL;
        if ($message->isDying()) {
            $message->done();
            echo 'JOB REMOVED', PHP_EOL;
        } else {
            $message->reject();
        }
    } else {
        $message->done();
        echo '[x] ', $message->getPayload(), PHP_EOL;
    }
});
