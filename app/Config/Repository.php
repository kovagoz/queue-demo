<?php

namespace App\Config;

use App\Contracts\Config\Repository as RepositoryContract;

class Repository implements RepositoryContract
{
    /**
     * @var array
     */
    protected $values = [];

    /**
     * Create new configuration object.
     *
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->values = $values;
    }

    /**
     * Check if a configuration value is exists.
     *
     * @param string $offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->values);
    }

    /**
     * Get a configuration value.
     *
     * @param string $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        if (!isset($this[$offset])) {
            return null;
        }

        return $this->values[$offset];
    }

    /**
     * Set a configuration value.
     *
     * @param string $offset
     * @param mixed  $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->values[$offset] = $value;
    }

    /**
     * Unset a configuration value.
     *
     * @param string $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->values[$offset]);
    }

    /**
     * Dump the configuration as an array.
     *
     * @return array
     */
    public function dump()
    {
        return $this->values;
    }
}
