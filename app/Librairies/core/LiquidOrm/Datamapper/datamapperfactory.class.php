<?php

declare(strict_types=1);

class DataMapperFactory
{
    protected ContainerInterface $container;

    /**
     * Main constructor
     * ================================================================================================
     *@return void
     */
    public function __construct()
    {
        $this->set_container();
    }

    /**

     * Create method
     * =================================================================================================
     * @param string $databaseConnexionObject
     * @param string $dataMapperEnvConfigObject
     *@return DataMapperInterface
     */
    public function create(string $databaseConnexionString) : DataMapperInterface
    {
        $databaseConnexionObject = $this->container->make($databaseConnexionString);
        if (!$databaseConnexionObject instanceof DatabaseConnexionInterface) {
            throw new DataMapperExceptions($databaseConnexionString . ' is not a valid database connexion Object!');
        }
        return $this->container->make(DataMapper::class);
    }

    public function set_container() : self
    {
        $this->container = Container::getInstance();
        return $this;
    }
}