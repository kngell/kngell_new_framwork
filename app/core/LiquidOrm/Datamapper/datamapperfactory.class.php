<?php

declare(strict_types=1);

class DataMapperFactory
{
    /**
     * =====================================================================
     * Main constructor
     * =====================================================================
     *@return void
     */
    public function __construct()
    {
    }

    /**
     * =====================================================================
     * Create method
     * =====================================================================
     * @param string $databaseConnexionObject
     * @param string $dataMapperEnvConfigObject
     *@return DataMapperInterface
     */
    public function create(string $databaseConnexionString, string $dataMapperEnvConfig) : DataMapperInterface
    {
        $credentials = (new $dataMapperEnvConfig([]))->getDatabaseCredentials('mysql');
        $databaseConnexionObject = new $databaseConnexionString($credentials);
        if (!$databaseConnexionObject instanceof DatabaseConnexionInterface) {
            throw new DataMapperExceptions($databaseConnexionString . ' is not a valid database connexion Object!');
        }
        return new DataMapper($databaseConnexionObject);
    }
}
