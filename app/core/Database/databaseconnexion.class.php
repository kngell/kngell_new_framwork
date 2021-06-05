<?php

declare(strict_types=1);
use PDO;

class DatabaseConnexion implements DatabaseConnexionInterface
{
    /**
     * @var PDO
     */
    protected PDO $con;

    /**
     * @var array
     */
    protected array $credentials;
    //=======================================================================
    //Main contructor
    //=======================================================================

    /**
     * Main contructor method
     * @param array $credentials
     * @return void
     */
    public function __contructs(array $credentials)
    {
        $this->credentials = $credentials;
    }

    //=======================================================================
    //Create a new data base connexion
    //=======================================================================

    /**
     * @inheritDoc
     */
    public function open() :PDO
    {
        // Set Options
        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci',
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET CHARACTER SET UTF8mb4',
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_FOUND_ROWS => true
        ];
        if (!isset($this->con)) {
            try {
                $this->con = new PDO($this->credentials['dsn'], $this->credentials['dbUser'], $this->credentials['dbPass'], $options);
            } catch (PDOException $e) {
                throw new DatabaseConnexionExceptions($e->getMessage(), (int)$e->getCode());
                die('Error : ' . $this->error);
            }
        }
        return $this->con;
    }

    //=======================================================================
    //close database connexion
    //=======================================================================

    /**
    * @inheritDoc
    */
    public function close():void
    {
        $this->con = null;
    }
}
