<?php

namespace App\Contracts\Queue;

interface Message
{
    public function getPayload();

    public function reject();

    public function rejectCounter();
}
