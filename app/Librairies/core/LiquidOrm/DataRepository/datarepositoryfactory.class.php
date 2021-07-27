<?php

declare(strict_types=1);

class DataRepositoryFactory
{
    protected string $tableSchema;
    protected string $tableSchemaID;
    protected string $crudIdentifier;
    protected ContainerInterface $container;

    /**
     * Main constructor
     *==================================================================
     */
    public function __construct()
    {
    }

    /**
     * Create Data Repository
     *==================================================================
     * @param string $datarepositoryString
     * @return DataRepositoryInterface
     */
    public function create(string $datarepositoryString) : DataRepositoryInterface
    {
        $this->initializeLiquidOrmManager();
        $dataRepositoryObject = $this->container->make($datarepositoryString);
        if (!$dataRepositoryObject instanceof DataRepositoryInterface) {
            throw new BaseUnexpectedValueException($datarepositoryString . ' is not a valid repository Object!');
        }
        return $dataRepositoryObject;
    }

    public function initializeLiquidOrmManager()
    {
        $ormManager = $this->container->bind(LiquidOrmManager::class, fn () => new LiquidOrmManager($this->tableSchema, $this->tableSchemaID))->make(LiquidOrmManager::class);
        return $ormManager->initialize();
    }

    public function set_container() : self
    {
        $this->container = Container::getInstance();
        return $this;
    }

    public function initParams(string $crudIdentifier, string $tableSchema, string $tableSchemaID)
    {
        $this->crudIdentifier = $crudIdentifier;
        $this->tableSchema = $tableSchema;
        $this->tableSchemaID = $tableSchemaID;
        return $this;
    }
}