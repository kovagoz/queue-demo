<?php

namespace App\Log\Drivers;

use App\Contracts\Log\Driver;
use App\Contracts\Database\Connection;
use App\Log\Drivers\Database\LogEntry;

class DatabaseDriver implements Driver
{
    /**
     * Create new database logger instance.
     *
     * @param Connection $db
     */
    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     * @return void
     */
    public function log($level, $message)
    {
        (new LogEntry($level, $message))->save($this->db);
    }
}
