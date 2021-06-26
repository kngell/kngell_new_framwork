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
    protected array $options;

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
    public function __construct(DataMapper $datamapper = null, QueryBuilder $querybuilder = null, string $tableSchema = '', string $tableSchmaID = '', ?array $options = [])
    {
        $this->datamapper = $datamapper;
        $this->querybuilder = $querybuilder;
        $this->tableSchema = $tableSchema;
        $this->tableSchemaID = $tableSchmaID;
        $this->options = $options;
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
    public function create(array $fields = []): int
    {
        try {
            $arg = ['table' => $this->getSchema(), 'type' => 'insert', 'fields' => $fields];
            $query = $this->querybuilder->buildQuery($arg)->insert();
            $this->datamapper->persist($query, $this->datamapper->buildQueryParameters($fields));
            if ($this->datamapper->numrow() == 1) {
                return $this->lastID();
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
    public function read(array $selectors = [], array $conditions = [], array $params = [], array $options = [])
    {
        try {
            $arg = [
                'table' => $this->getSchema(),
                'type' => 'select',
                'selectors' => $selectors,
                'where' => array_merge($conditions, isset($options['where']) ? $options['where'] : []),
                'params' => $params,
                'extras' => $options,
                'table_join' => isset($options['table_join']) ? $options['table_join'] : []
            ];
            $query = $this->querybuilder->buildQuery($arg)->select();
            $this->datamapper->persist($query, $this->datamapper->buildQueryParameters($arg['where'], $params));
            if ($this->datamapper->numrow() > 0) {
                return $this->datamapper->results($options);
            }
            return -1;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function show(array $options) : object
    {
        try {
            $arg = [
                'table' => $this->getSchema(),
                'type' => 'show',
            ];
            $query = $this->querybuilder->buildQuery($arg)->show();
            $this->datamapper->persist($query, $this->datamapper->buildQueryParameters([], []));
            if ($this->datamapper->numrow() > 0) {
                return $this->datamapper->results($options);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Update data from data base
     * =====================================================================
     *@inheritDoc
     */
    public function update(array $fields = [], array $conditions = []): ?int
    {
        try {
            $arg = [
                'table' => $this->getSchema(),
                'type' => 'update',
                'fields' => $fields,
                'where' => $conditions
            ];
            $query = $this->querybuilder->buildQuery($arg)->update();
            $this->datamapper->persist($query, $this->datamapper->buildQueryParameters($fields, $conditions));
            if ($this->datamapper->numrow() == 1) {
                return $this->datamapper->numrow();
            }
            return 0;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Delete data from database
     * =====================================================================
     *@inheritDoc
     */
    public function delete(array $conditions = []): ?int
    {
        try {
            $arg = [
                'table' => $this->getSchema(),
                'type' => 'delete',
                'conditions' => $conditions
            ];
            $query = $this->querybuilder->buildQuery($arg)->delete();
            $this->datamapper->persist($query, $this->datamapper->buildQueryParameters($conditions));
            if ($this->datamapper->numrow() == 1) {
                return $this->datamapper->numrow();
            }
            return 0;
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
    public function search(array $selectors = [], array $searchconditions = [])
    {
        try {
            $arg = [
                'table' => $this->getSchema(),
                'type' => 'search',
                'selectors' => $selectors,
                'conditions' => $searchconditions
            ];
            $query = $this->querybuilder->buildQuery($arg)->search();
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
     * @inheritDoc
     * =====================================================================
     *
     * @param string $query
     * @param array $conditions
     * @return void
     */
    public function customQuery(string $query = '', array $conditions = [])
    {
        try {
            $arg = [
                'table' => $this->getSchema(),
                'type' => 'custom',
                'custom' => $query,
                'conditions' => $conditions,
            ];
            $query = $this->querybuilder->buildQuery($arg)->search();
            $this->datamapper->persist($query, $this->datamapper->buildQueryParameters($conditions));
            if ($this->datamapper->numrow() > 0) {
                return $this->datamapper->results();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function aggregate(string $type, ?string $fields = 'id', array $conditions = [])
    {
        $args = ['table' => $this->getSchema(), 'primary_key' => $this->getSchemaID(), 'type' => 'select', 'aggregate' => $type, 'aggregate_field' => $fields, 'conditions' => $conditions];
        $query = $this->querybuilder->buildQuery($args)->select();
        $this->datamapper->persist($query, $this->datamapper->buildQueryParameters($conditions));
        if ($this->datamapper->numrow() > 0) {
            return $this->datamapper->column();
        }
    }

    public function countRecords(array $conditions = [], ?string $fields = 'id'): int
    {
        if ($this->getSchemaID() != '') {
            return empty($conditions) ? $this->aggregate('count', $this->getSchemaID()) : $this->aggregate('count', $this->getSchemaID(), $conditions);
        }
    }

    /**
     * @inheritDoc
     *
     * @param array $selectors
     * @param array $conditions
     * @return Object|null
     */
    public function get(array $selectors = [], array $conditions = []) : ?Object
    {
        $args = ['table' => $this->getSchema(), 'type' => 'select', 'selectors' => $selectors, 'conditions' => $conditions];
        $query = $this->querybuilder->buildQuery($args)->select();
        $this->datamapper->persist($query, $this->datamapper->buildQueryParameters($conditions));
        if ($this->datamapper->numrow() >= 0) {
            return $this->datamapper->result();
        }
    }
}