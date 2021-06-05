<?php

declare(strict_types=1);

class Crud implements CrudInterface
{
    /**
     * DataMapper Object
     */
    protected DataMapper $datamapper;
    /**
     * Query Builder
     */
    protected QueryBuilder $querybuilder;
    /**
    * Table Name
    */
    protected string $tableSchema;
    /**
    * Table Name primary key
    */
    protected string $tableSchemaID;

    /**
     * =====================================================================
     * Main constructor
     * =====================================================================
     * Initialize properties
     * @param DataMapper $datamapper
     * @param QueryBuilder $querybuilder
     * @param string $tableSchma
     * @param string $tableSchmaID
     *@return void
     */
    public function __construct(DataMapper $datamapper, QueryBuilder $querybuilder, string $tableShema, string $tableSchmaID)
    {
        $this->datamapper = $datamapper;
        $this->querybuilder = $querybuilder;
        $this->tableSchema = $tableShema;
        $this->tableSchemaID = $tableSchmaID;
    }

    /**
     * =====================================================================
     * Get Table Name
     * =====================================================================
     *@inheritDoc
     */
    public function getSchema(): string
    {
        return $this->tableSchema;
    }

    /**
     * =====================================================================
     * Get Table ID
     * =====================================================================
     *@inheritDoc
     */
    public function getSchemaID(): string
    {
        return $this->tableSchemaID;
    }

    /**
     * =====================================================================
     * Get last insert ID
     * =====================================================================
     *@inheritDoc
     */
    public function lastID(): int
    {
        return $this->datamapper->getLasID();
    }

    /**
     * =====================================================================
     * Insert data into database
     * =====================================================================
     *@inheritDoc
     */
    public function create(array $fields = []): bool
    {
        try {
            $arg = ['table' => $this->getSchema(), 'type' => 'insert', 'fields' => $fields];
            $query = $this->querybuilder->builQuery($arg)->insert();
            $this->datamapper->persist($query, $this->datamapper->buildQueryParameters($fields));
            if ($this->datamapper->numrow() == 1) {
                return true;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * =====================================================================
     * Select data from data base
     * =====================================================================
     *@inheritDoc
     */
    public function read(array $selectors = [], array $conditions = [], array $params = [], array $options = []): array
    {
        try {
            $arg = [
                'table' => $this->getSchema(),
                'type' => 'select',
                'selectors' => $selectors,
                'conditions' => $conditions,
                'params' => $params,
                'extras' => $options
            ];
            $query = $this->querybuilder->builQuery($arg)->select();
            $this->datamapper->persist($query, $this->datamapper->buildQueryParameters($conditions, $params));
            if ($this->datamapper->numrow() > 0) {
                return $this->datamapper->results();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * =====================================================================
     * Update data from data base
     * =====================================================================
     *@inheritDoc
     */
    public function update(array $fields = [], string $primary_key): bool
    {
        try {
            $arg = [
                'table' => $this->getSchema(),
                'type' => 'update',
                'fields' => $fields,
                'primary_key' => $primary_key
            ];
            $query = $this->querybuilder->builQuery($arg)->update();
            $this->datamapper->persist($query, $this->datamapper->buildQueryParameters($fields));
            if ($this->datamapper->numrow() == 1) {
                return true;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * =====================================================================
     * Delete data from database
     * =====================================================================
     *@inheritDoc
     */
    public function delete(array $conditions = []): bool
    {
        try {
            $arg = [
                'table' => $this->getSchema(),
                'type' => 'delete',
                'conditions' => $conditions
            ];
            $query = $this->querybuilder->builQuery($arg)->delete();
            $this->datamapper->persist($query, $this->datamapper->buildQueryParameters($conditions));
            if ($this->datamapper->numrow() == 1) {
                return true;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * =====================================================================
     * Search data from data base
     * =====================================================================
     *@inheritDoc
     */
    public function search(array $selectors = [], array $searchconditions = []): array
    {
        try {
            $arg = [
                'table' => $this->getSchema(),
                'type' => 'search',
                'selectors' => $selectors,
                'conditions' => $searchconditions
            ];
            $query = $this->querybuilder->builQuery($arg)->search();
            $this->datamapper->persist($query, $this->datamapper->buildQueryParameters($searchconditions));
            if ($this->datamapper->numrow() > 0) {
                return $this->datamapper->results();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * =====================================================================
     * Search data from data base
     * =====================================================================
     *@inheritDoc
     */
    public function customQuery(string $query = [], array $conditions = [])
    {
        try {
            $arg = [
                'table' => $this->getSchema(),
                'type' => 'custom',
                'conditions' => $conditions
            ];
            $query = $this->querybuilder->builQuery($arg)->search();
            $this->datamapper->persist($query, $this->datamapper->buildQueryParameters($conditions));
            if ($this->datamapper->numrow() > 0) {
                return $this->datamapper->results();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}