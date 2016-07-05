<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Core\Application;

//---------------------------------------------------------
//  PHP settings
//---------------------------------------------------------

setlocale(LC_ALL, 'hu_HU.UTF-8');

date_default_timezone_set('Europe/Budapest');

error_reporting(E_ALL);

ini_set('display_errors', 1);

//---------------------------------------------------------
//  Create and boot the application
//---------------------------------------------------------

$app = (new Application)->boot();
