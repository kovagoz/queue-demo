<?php

$router->get('hello', function () {
    return 'hello world';
});

$router->get('log', function ($request, $app) {
    return $app('db')->execute('SELECT * FROM log ORDER BY created_at DESC');
});
