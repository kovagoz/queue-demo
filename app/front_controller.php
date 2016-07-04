<?php

require __DIR__ . '/bootstrap.php';

$request = $app('request');

$dispatcher = $app('http.dispatcher');

$response = $dispatcher->dispatch($request);

$response->send();
