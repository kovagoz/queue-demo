<?php

$router->get('log', function ($request, $app) {
    return $app('audit')
        ->findSince($request->getParam('since'))
        ->toArray();
});
