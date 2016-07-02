<?php

require __DIR__ . '/../app/bootstrap.php';

$app('queue')->put('hello world');
