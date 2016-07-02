<?php

namespace App\Providers;

use App\Container;

abstract class ServiceProvider
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    abstract public function register();
}
