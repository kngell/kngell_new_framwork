<?php

declare(strict_types=1);

class DataRepositoryFactory
{
    protected string $tableSchema;
    protected string $tableSchameID;
    protected string $crudIdentifier;

    /**
     * Main constructor
     *==================================================================
     * @param string $crudIdentifer
     * @param string $tableSchema
     * @param string $tableSchemaID
     */
    public function __construct(string $crudIdentifer, string $tableSchema, string $tableSchemaID)
    {
        $this->crudIdentifier = $crudIdentifer;
        $this->tableSchema = $tableSchema;
        $this->tableSchameID = $tableSchemaID;
    }

    /**
     * Create Data Repository
     *==================================================================
     * @param string $datarepositoryString
     * @return DataRepositoryInterface
     */
    public function create(string $datarepositoryString) : DataRepositoryInterface
    {
        $entityManager = $this->initializeLiquidOrmManager();
        $dataRepositoryObject = new $datarepositoryString($entityManager);
        if (!$dataRepositoryObject instanceof DataRepositoryInterface) {
            throw new BaseUnexpectedValueException($datarepositoryString . ' is not a valid repository Object!');
        }
        return $dataRepositoryObject;
    }

    public function initializeLiquidOrmManager()
    {
        $environmentConfiguration = new DataMapperEnvironmentConfig(YamlConfig::file('database'));
        $ormManager = new LiquidOrmManager($environmentConfiguration, $this->tableSchema, $this->tableSchameID);
        return $ormManager->initialize();
    }
}