<?php

namespace App\Log\Drivers\Database;

use App\Contracts\Database\Connection;

class LogEntryRepository
{
    /**
     * Create new log entry repository.
     *
     * @param Connection $db
     */
    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * Find the recent log entries.
     *
     * @param integer $limit
     * @return \App\Contracts\Database\ResultSet
     */
    public function findRecent($limit = 30)
    {
        $query = 'SELECT * FROM `log` ORDER BY `id` DESC LIMIT ?';

        return $this->db->execute($query, [intval($limit)]);
    }

    /**
     * Find entries with ID greater than the given one.
     *
     * @param integer $id
     * @return \App\Contracts\Database\ResultSet
     */
    public function findSince($id)
    {
        if (empty($id)) {
            return $this->findRecent();
        }

        $query = 'SELECT * FROM `log` WHERE `id` > ? ORDER BY `id` DESC';

        return $this->db->execute($query, [intval($id)]);
    }
}
