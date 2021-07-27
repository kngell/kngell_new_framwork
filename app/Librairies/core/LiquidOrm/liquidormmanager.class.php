<?php

declare(strict_types=1);

class LiquidOrmManager
{
    protected string $tableSchema;
    protected string $tableSchameID;
    protected DataMapperEnvironmentConfig $datamapperEnvConfig;
    protected array $options;
    protected ContainerInterface $container;

    /**
     * Main contructor
     *=====================================================================
     * @param DataMapperEnvironmentConfig $datamapperEnvConfig
     * @param string $tableSchema
     * @param string $tableSchemaID
     */
    public function __construct(string $tableSchema, string $tableSchemaID, ?array $options = [])
    {
        $this->set_container();
        $this->tableSchema = $tableSchema;
        $this->tableSchameID = $tableSchemaID;
        $this->options = $options;
    }

    /**
     * Initializind ORM DataBase Management
     * =====================================================================
     * @return void
     */
    public function initialize()
    {
        $entitymanagerFactory = $this->container->make(EntityManagerFactory::class);
        return $entitymanagerFactory->create(Crud::class, $this->tableSchema, $this->tableSchameID, $this->options);
    }

    /**
     * Set container
     * =====================================================================
     * @param ContainerInterface $container
     * @return self
     */
    public function set_container() : self
    {
        $this->container = Container::getInstance();
        return $this;
    }

    public function set_env_config(DataMapperEnvironmentConfig $env)
    {
        $this->datamapperEnvConfig = $env;
        return $this;
    }
}