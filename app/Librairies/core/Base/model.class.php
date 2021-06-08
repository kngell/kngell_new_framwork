<?php

declare(strict_types=1);

class Model
{
    private Object $repository;

    /**
     * Main Constructor
     * =====================================================================
     * @param string $tableSchema
     * @param string $tableSchemaID
     */
    public function __construct(string $tableSchema, string $tableSchemaID)
    {
        if (empty($tableSchema) || empty($tableSchemaID)) {
            throw new BaseInvalidArgumentException('These arguments are required');
        }
        $factory = new DataRepositoryFactory('basicCrud', $tableSchema, $tableSchemaID);
        $this->repository = $factory->create(DataRepository::class);
    }

    /**
     * Get Data Repository method
     * =====================================================================
     * @return DataRepositoryInterface
     */
    public function getRepository() : DataRepository
    {
        return $this->repository;
    }
}