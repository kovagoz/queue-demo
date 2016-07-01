<?php

require __DIR__ . '/../app/bootstrap.php';

$container->make('queue')->put('hello world');
