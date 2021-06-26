<?php

declare(strict_types=1);

class DataMapperFactory
{
    protected static ContainerInterface $container;

    /**
     * Main constructor
     * ================================================================================================
     *@return void
     */
    public function __construct()
    {
    }

    /**

     * Create method
     * =================================================================================================
     * @param string $databaseConnexionObject
     * @param string $dataMapperEnvConfigObject
     *@return DataMapperInterface
     */
    public function create(string $databaseConnexionString, Object $dataMapperEnvConfig) : DataMapperInterface
    {
        $credentials = $dataMapperEnvConfig->getDatabaseCredentials('mysql');
        $databaseConnexionObject = self::$container->load([$databaseConnexionString => ['credentials' => $credentials]])->$databaseConnexionString;
        if (!$databaseConnexionObject instanceof DatabaseConnexionInterface) {
            throw new DataMapperExceptions($databaseConnexionString . ' is not a valid database connexion Object!');
        }
        return self::$container->load([DataMapper::class => ['_con' => $databaseConnexionObject]])->DataMapper;
    }

    public function set_container(ContainerInterface $container) : self
    {
        $this->container = $container;
        return $this;
    }
}