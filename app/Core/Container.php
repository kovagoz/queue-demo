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
     * @throws InvalidArgumentException
     */
    public function make($abstract)
    {
        if ($this->isAlias($abstract)) {
            $abstract = $this->resolveAlias($abstract);
        }

        if (!$this->isBound($abstract)) {
            throw new InvalidArgumentException("Cannot resolve {$abstract}");
        }

        if ($this->isCallable($abstract)) {
            return call_user_func($this->bindings[$abstract], $this);
        }

        return $this->bindings[$abstract];
    }

    /**
     * Check whether the resolvable entity is just an alias.
     *
     * @param string $abstract
     * @return boolean
     */
    protected function isAlias($abstract)
    {
        return array_key_exists($abstract, $this->aliases);
    }

    /**
     * Get the real abstract behind the alias.
     *
     * @param string $alias
     * @return string
     */
    protected function resolveAlias($alias)
    {
        return $this->aliases[$alias];
    }

    /**
     * Determine if abstract is bound.
     *
     * @param string $abstract
     * @return boolean
     */
    protected function isBound($abstract)
    {
        return array_key_exists($abstract, $this->bindings);
    }

    /**
     * Determine if abstract bound to a callable entity.
     *
     * @param string $abstract
     * @return boolean
     */
    protected function isCallable($abstract)
    {
        return is_callable($this->bindings[$abstract]);
    }
}
