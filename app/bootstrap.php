<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Application;

setlocale(LC_ALL, 'hu_HU.UTF-8');

date_default_timezone_set('Europe/Budapest');

error_reporting(E_ALL);

ini_set('display_errors', 1);

$app = (new Application)->boot();
