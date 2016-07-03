<?php

namespace App\Database\Drivers\PdoMysql;

use App\Contracts\Database\Connection;
use App\Database\Platforms\Mysql\MysqlConfiguration as Configuration;
use PDO;

class PdoMysqlConnection implements Connection
{
    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @var PDO
     */
    protected $pdo;

    /**
     * Create new connection instance.
     *
     * @param Configuration $config
     */
    public function __construct(Configuration $config)
    {
        $this->config = $config;
    }

    /**
     * Execute a query.
     *
     * @param mixed $query
     * @param array $params
     * @return \App\Contracts\Database\ResultSet
     */
    public function execute($query, array $params = [])
    {
        $stmt = $this->conn()->prepare($query);

        $stmt->execute($params);

        return new PdoMysqlResultSet($stmt);
    }

    /**
     * Lazy create the connection.
     *
     * @return PDO
     */
    protected function conn()
    {
        if ($this->pdo === null) {
            $this->pdo = $this->createConnection();
        }

        return $this->pdo;
    }

    /**
     * Create the PDO object.
     *
     * @return PDO
     */
    protected function createConnection()
    {
        return new PDO(
            $this->config->getDsn(),
            $this->config->getUsername(),
            $this->config->getPassword(),
            $this->getConnectionOptions()
        );
    }

    protected function getConnectionOptions()
    {
        $options = [];

        $charset = $this->config->getCharset();

        if ($charset !== null) {
            $options[PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES {$charset}";
        }

        return $options;
    }
}
