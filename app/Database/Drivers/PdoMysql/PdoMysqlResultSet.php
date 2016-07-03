<?php

namespace App\Database\Drivers\PdoMysql;

use App\Contracts\Database\ResultSet;
use PDOStatement;
use PDO;
use IteratorAggregate;

class PdoMysqlResultSet implements ResultSet, IteratorAggregate
{
    /**
     * Create new result set.
     *
     * Set fetch mode to retrieve rows as associated arrays.
     *
     * @param PDOStatement $stmt
     */
    public function __construct(PDOStatement $stmt)
    {
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $this->stmt = $stmt;
    }

    /**
     * Retrieve the PDO statement iterator.
     *
     * @return \Traversable
     */
    public function getIterator()
    {
        return $this->stmt;
    }
}
