<?php

namespace App\Contracts\Core;

use Closure;

interface Container
{
    /**
     * Bind a resolver to the container.
     *
     * @param string  $abstract
     * @param Closure $resolver
     * @return void
     */
    public function bind($abstract, Closure $resolver);

    /**
     * Bind a resolver to the container what provides the same instance every time.
     *
     * @param string  $abstract
     * @param Closure $resolver
     * @return void
     */
    public function singleton($abstract, Closure $resolver);

    /**
     * Bind a concrete instance to the container.
     *
     * @param string $abstract
     * @param mixed  $instance
     * @return void
     */
    public function instance($abstract, $instance);

    /**
     * Register an alias for an abstract.
     *
     * @param string $abstract
     * @param string $alias
     * @return void
     */
    public function alias($abstract, $alias);
    
    /**
     * Make an instance.
     *
     * @param string $abstract
     * @return mixed
     */
    public function make($abstract);
}
