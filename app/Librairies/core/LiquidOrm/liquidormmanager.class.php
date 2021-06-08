<?php

declare(strict_types=1);

class LiquidOrmManager
{
    protected string $tableSchema;
    protected string $tableSchameID;
    protected DataMapperEnvironmentConfig $datamapperEnvConfig;
    protected array $options;

    /**
     * Main contructor
     *=====================================================================
     * @param DataMapperEnvironmentConfig $datamapperEnvConfig
     * @param string $tableSchema
     * @param string $tableSchemaID
     */
    public function __construct(DataMapperEnvironmentConfig $datamapperEnvConfig, string $tableSchema, string $tableSchemaID, ?array $options = [])
    {
        $this->datamapperEnvConfig = $datamapperEnvConfig;
        $this->tableSchema = $tableSchema;
        $this->tableSchameID = $tableSchemaID;
        $this->options = $options;
    }

    /**
     * Initializind ORM DataBase Management
     *=====================================================================
     * @return void
     */
    public function initialize()
    {
        $datamapper = (new DataMapperFactory())->create(DatabaseConnexion::class, $this->datamapperEnvConfig);
        if ($datamapper) {
            $querybuilder = (new QueryBuilderFactory())->create(QueryBuilder::class);
            if ($querybuilder) {
                $entitymanagerFactory = new EntityManagerFactory($datamapper, $querybuilder);
                return $entitymanagerFactory->create(Crud::class, $this->tableSchema, $this->tableSchameID, $this->options);
            }
        }
    }
}