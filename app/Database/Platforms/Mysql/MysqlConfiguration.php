<?php

namespace App\Database\Platforms\Mysql;

/**
 * Driver independent MySQL configuration.
 */
class MysqlConfiguration
{
    /**
     * @var string
     */
    protected $host;

    /**
     * @var integer
     */
    protected $port;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $database;

    /**
     * @var string
     */
    protected $charset = 'utf8';

    /**
     * Create new MySQL connection configuration.
     *
     * @param string  $host
     * @param integer $port
     */
    public function __construct($host = 'localhost', $port = 3306)
    {
        $this->setHost($host);
        $this->setPort($port);
    }

    /**
     * Set the hostname.
     *
     * @param string $host
     * @return self
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * Get the hostname.
     *
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Set the port where MySQL is listening.
     *
     * @param integer $port
     * @return self
     */
    public function setPort($port)
    {
        $this->port = intval($port);

        return $this;
    }

    /**
     * Get the port where MySQL is listening.
     *
     * @return integer
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Set the username to connect with.
     *
     * @param string $username
     * @return self
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the username to connect with.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set connection password.
     *
     * @param string $password
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get connection password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the database name.
     *
     * @param string $database
     * @return self
     */
    public function setDatabase($database)
    {
        $this->database = $database;

        return $this;
    }

    /**
     * Get the database name.
     *
     * @return string
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * Set the character set the client will use to send SQL statements to the server.
     *
     * @param string $charset
     * @return self
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;

        return $this;
    }

    /**
     * Get client's character set.
     *
     * @return string
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * Compose the Data Source Name.
     *
     * @return string
     */
    public function getDsn()
    {
        return sprintf(
            'mysql:host=%s;port=%s;dbname=%s',
            $this->getHost(),
            $this->getPort(),
            $this->getDatabase()
        );
    }

    /**
     * Return the DSN if the configuration object is converted to string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getDsn();
    }
}
