<?php

namespace App\Contracts\Database;

/**
 * Database query result set.
 */
interface ResultSet
{
    /**
     * Convert result set to array.
     *
     * @return array
     */
    public function toArray();
}
