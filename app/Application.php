<?php

namespace App;

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
    ];

    /**
     * Create new application instance.
     *
     * @param Container $container
     */
    public function __construct(Container $container = null)
    {
        $this->container = $container ?: new Container;
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
     * Get a service from the IoC container.
     *
     * @param string $service
     * @return mixed
     */
    public function __invoke($service)
    {
        return $this->container->make($service);
    }
}
