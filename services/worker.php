<?php

require_once __DIR__ . '/app/bootstrap.php';

use App\Domain\MessageProcessor;

$app(MessageProcessor::class)->start();
