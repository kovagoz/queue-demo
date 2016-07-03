<?php

namespace App\Contracts\Database;

interface Connection
{
    /**
     * Execute a query.
     *
     * @param mixed $query
     * @param array $params
     * @return ResultSet
     */
    public function execute($query, array $params = []);
}
