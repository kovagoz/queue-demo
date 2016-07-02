<?php

require __DIR__ . '/../app/bootstrap.php';

use App\Event\Listener;

class GossipGirl extends Listener
{
    public function handle($event)
    {
        echo "It's ", $event->format('H:i:s'), PHP_EOL;
    }
}

$app('events')
    ->listen(DateTime::class, new GossipGirl)
    ->listen(DateTime::class, function ($event) {
        echo "It's ", $event->format('H:i:s'), PHP_EOL;
    })
    ->fire(new DateTime);
