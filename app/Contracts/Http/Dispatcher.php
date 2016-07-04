<?php

namespace App\Contracts\Http;

interface Dispatcher
{
    /**
     * Dispatch the request.
     *
     * @param Request $request
     * @return void
     */
    public function dispatch(Request $request);
}
