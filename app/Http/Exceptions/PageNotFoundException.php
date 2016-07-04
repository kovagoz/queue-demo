<?php

namespace App\Http\Exceptions;

use App\Contracts\Http\Request;
use RuntimeException;

class PageNotFoundException extends RuntimeException
{
    /**
     * Create new exception.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct(
            "No route found to: {$request->getPath()}"
        );
    }
}
