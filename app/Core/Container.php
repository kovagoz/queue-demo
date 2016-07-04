<?php

namespace App\Core;

use App\Contracts\Core\Container as ContainerContract;
use Closure;
use InvalidArgumentException;

/**
 * A simple IoC container.
 */
class Container implements ContainerContract
{
    /**
     * Registered resolvers.
     *
     * @var array
     */
    protected $bindings = [];

    /**
     * Registered aliases.
     *
     * @var array
     */
    protected $aliases = [];

    /**
     * Bind a resolver to the container.
     *
     * @param string  $abstract
     * @param Closure $resolver
     * @return void
     */
    public function bind($abstract, Closure $resolver)
    {
        $this->bindings[$abstract] = $resolver;
    }

    /**
     * Bind a resolver to the container what provides the same instance every time.
     *
     * @param string  $abstract
     * @param Closure $resolver
     * @return void
     */
    public function singleton($abstract, Closure $resolver)
    {
        $this->bindings[$abstract] = function () use ($abstract, $resolver) {
            $instance = call_user_func($resolver, $this);

            // Rebind the result to the same abstract.
            $this->bindings[$abstract] = function () use ($instance) {
                return $instance;
            };

            return $instance;
        };
    }

    /**
     * Bind a concrete instance to the container.
     *
     * @param string $abstract
     * @param mixed  $instance
     * @return void
     */
    public function instance($abstract, $instance)
    {
        $this->bindings[$abstract] = function () use ($instance) {
            return $instance;
        };
    }

    /**
     * Register an alias for an abstract.
     *
     * @param string $abstract
     * @param string $alias
     * @return void
     */
    public function alias($abstract, $alias)
    {
        $this->aliases[$alias] = $abstract;
    }

    /**
     * Make an instance.
     *
     * @param string $abstract
     * @return mixed
     */
    public function make($abstract)
    {
        if (array_key_exists($abstract, $this->aliases)) {
            $abstract = $this->aliases[$abstract];
        }

        if (!array_key_exists($abstract, $this->bindings)) {
            throw new InvalidArgumentException;
        }

        if (is_callable($this->bindings[$abstract])) {
            return call_user_func($this->bindings[$abstract], $this);
        }

        return $this->bindings[$abstract];
    }
}
