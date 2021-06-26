<?php

declare(strict_types=1);

class DataRepositoryFactory
{
    protected string $tableSchema;
    protected string $tableSchemaID;
    protected string $crudIdentifier;
    protected static ContainerInterface $container;

    /**
     * Main constructor
     *==================================================================
     * @param string $crudIdentifer
     * @param string $tableSchema
     * @param string $tableSchemaID
     */
    public function __construct(string $crudIdentifier, string $tableSchema, string $tableSchemaID)
    {
        $this->crudIdentifier = $crudIdentifier;
        $this->tableSchema = $tableSchema;
        $this->tableSchemaID = $tableSchemaID;
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
        $dataRepositoryObject = self::$container->load([$datarepositoryString => ['em' => $entityManager]])->$datarepositoryString;
        if (!$dataRepositoryObject instanceof DataRepositoryInterface) {
            throw new BaseUnexpectedValueException($datarepositoryString . ' is not a valid repository Object!');
        }
        return $dataRepositoryObject;
    }

    public function initializeLiquidOrmManager()
    {
        $environmentConfiguration = self::$container->load([DataMapperEnvironmentConfig::class => ['credentials' => YamlConfig::file('database')]])->DataMapperEnvironmentConfig;
        $ormManager = self::$container->load([LiquidOrmManager::class => ['tableSchema' => $this->tableSchema, 'tableSchemaID' => $this->tableSchemaID, 'options' => []]])->LiquidOrm->set_env_config($environmentConfiguration);
        return $ormManager->initialize();
    }

    public function set_container(ContainerInterface $container) : self
    {
        $this->container = $container;
        return $this;
    }
}