<?php

require __DIR__ . '/../app/bootstrap.php';

use App\Mail\Message\PlainText as Message;

$msg = new Message;
$msg->addRecipient('kovago@gmail.com', 'Kovago Zoltan');
$msg->setSubject('queue test');
$msg->setBody('hello world!');

$container->make('mail')->send($msg);
