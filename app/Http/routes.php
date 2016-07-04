<?php

use App\Domain\MessageGenerator;

$router->get('log', function ($request, $app) {
    return $app('audit')
        ->findSince($request->getParam('since'))
        ->toArray();
});

$router->post('message', function ($request, $app) {
    $app(MessageGenerator::class)->publish();
});
