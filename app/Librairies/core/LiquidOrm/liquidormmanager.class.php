<?php

declare(strict_types=1);

class LiquidOrmManager
{
    protected string $tableSchema;
    protected string $tableSchameID;
    protected DataMapperEnvironmentConfig $datamapperEnvConfig;
    protected array $options;
    protected static ContainerInterface $container;

    /**
     * Main contructor
     *=====================================================================
     * @param DataMapperEnvironmentConfig $datamapperEnvConfig
     * @param string $tableSchema
     * @param string $tableSchemaID
     */
    public function __construct(string $tableSchema, string $tableSchemaID, ?array $options = [])
    {
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
        $datamapper = self::$container->load([DataMapperFactory::class => []])->DataMapperFactory->create(DatabaseConnexion::class, $this->datamapperEnvConfig);
        if ($datamapper) {
            $querybuilder = self::$container->load([QueryBuilderFactory::class => []])->QueryBuilderFactory->create(QueryBuilder::class);
            if ($querybuilder) {
                $entitymanagerFactory = self::$container->load([EntityManagerFactory::class => ['datamapper' => $datamapper, 'querybuilder' => $querybuilder]])->Entity;
                return $entitymanagerFactory->create(Crud::class, $this->tableSchema, $this->tableSchameID, $this->options);
            }
        }
    }

    /**
     * Set container
     * =====================================================================
     * @param ContainerInterface $container
     * @return self
     */
    public function set_container(ContainerInterface $container) : self
    {
        $this->container = $container;
        return $this;
    }

    public function set_env_config(DataMapperEnvironmentConfig $env)
    {
        $this->datamapperEnvConfig = $env;
        return $this;
    }
}