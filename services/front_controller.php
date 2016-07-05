<?php

require __DIR__ . '/../app/bootstrap.php';

$request = $app('request');

$dispatcher = $app('http.dispatcher');

$response = $dispatcher->dispatch($request);

$response->send();
