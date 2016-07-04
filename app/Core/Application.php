<?php

namespace App\Core;

use App\Contracts\Core\Container as ContainerContract;
use App\Providers;

class Application
{
    /**
     * Service providers.
     *
     * @var array
     */
    protected $providers = [
        Providers\QueueServiceProvider::class,
        Providers\MailServiceProvider::class,
        Providers\LogServiceProvider::class,
        Providers\EventServiceProvider::class,
        Providers\DatabaseServiceProvider::class,
        Providers\ConfigServiceProvider::class,
        Providers\HttpServiceProvider::class,
    ];

    /**
     * @var ContainerContract
     */
    protected $container;

    /**
     * Create new application instance.
     *
     * @param ContainerContract $container
     */
    public function __construct(ContainerContract $container = null)
    {
        $this->container = $container ?: new Container;

        $this->registerInstance();
    }

    /**
     * Bootstrap the application.
     *
     * @return self
     */
    public function boot()
    {
        foreach ($this->providers as $provider_class) {
            $provider = new $provider_class($this->container);
            $provider->register();
        }

        return $this;
    }

    /**
     * Get an object from the IoC container.
     *
     * @param string $abstract
     * @return mixed
     */
    public function make($abstract)
    {
        return $this->container->make($abstract);
    }

    /**
     * Get an object from the IoC container by calling the Application.
     *
     * @param string $abstract
     * @return mixed
     */
    public function __invoke($abstract)
    {
        return $this->make($abstract);
    }

    /**
     * Register the application itself into the IoC container.
     *
     * @return void
     */
    protected function registerInstance()
    {
        $this->container->instance(self::class, $this);
        $this->container->alias(self::class, 'app');
    }
}
