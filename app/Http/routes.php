<?php

$router->post('hello', function () {
    return [
        'created_at' => time(),
        'message'    => 'Lorem ipsum dolor sit amet'
    ];
});

$router->get('log', function ($request, $app) {
    return $app('db')->execute('SELECT * FROM log ORDER BY created_at DESC');
});
