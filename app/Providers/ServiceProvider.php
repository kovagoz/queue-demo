<?php

namespace App\Providers;

use App\Contracts\Core\Container;

abstract class ServiceProvider
{
    /**
     * IoC container.
     *
     * @var Container
     */
    protected $container;

    /**
     * Create new service provider instance.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Run some code after all of the providers have registered.
     *
     * @return void
     */
    public function boot()
    {
        // Bootstrap code here.
    }

    /**
     * Register services.
     *
     * @return void
     */
    abstract public function register();
}
