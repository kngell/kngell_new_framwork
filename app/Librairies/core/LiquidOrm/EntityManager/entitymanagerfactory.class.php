<?php

declare(strict_types=1);

class EntityManagerFactory
{
    /**
     *propertty
     */
    protected DataMapperInterface $datamapper;
    /**
     *property
     */
    protected QueryBuilderInterface $querybuilder;

    /**
    * =====================================================================
    * Main constructor
    * =====================================================================
     *
     * @param DataMapperInterface $datamapper
     * @param QueryBuilderInterface $querybuilder
     */
    public function __construct(DataMapperInterface $datamapper, QueryBuilderInterface $querybuilder)
    {
        $this->datamapper = $datamapper;
        $this->querybuilder = $querybuilder;
    }

    /**
    * =====================================================================
    * Create factory
    * =====================================================================
     *
     * @param string $crudString
     * @param string $tableSchma
     * @param string $tableShameID
     * @param array $options
     * @return EntityManagerInterface
     */
    public function create(string $crudString = '', string $tableSchma = '', string $tableShameID = '', array $options = []) : EntityManagerInterface
    {
        $crudObject = new $crudString($this->datamapper, $this->querybuilder, $tableSchma, $tableShameID, $options);
        if (!$crudObject instanceof CrudInterface) {
            throw new CrudExceptions($crudString . ' is not a valid crud object!');
        }
        return new EntityManager($crudObject);
    }
}