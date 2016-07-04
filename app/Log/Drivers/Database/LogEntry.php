<?php

namespace App\Log\Drivers\Database;

use App\Contracts\Database\Connection;
use Psr\Log\LogLevel;

/**
 * Database log entry.
 */
class LogEntry
{
    /**
     * @var string
     */
    protected $level;

    /**
     * @var string
     */
    protected $message;

    /**
     * Create new entry.
     *
     * @param string $message
     * @param string $level
     */
    public function __construct($message, $level = LogLevel::NOTICE)
    {
        $this->level   = $level;
        $this->message = $message;
    }

    /**
     * Persist the log entry.
     *
     * @param Connection $db
     * @return void
     */
    public function save(Connection $db)
    {
        $db->execute('INSERT INTO log (`level`, `message`) VALUES (:level, :message)', [
            ':level'   => $this->level,
            ':message' => $this->message
        ]);
    }
}
