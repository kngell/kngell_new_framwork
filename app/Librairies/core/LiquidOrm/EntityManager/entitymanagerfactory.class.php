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

    protected static ContainerInterface $container;

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
        $crudObject = self::$container->load([$crudString => ['datamapper' => $this->datamapper, 'querybuilder' => $this->querybuilder, 'tableSchema' => $tableSchma, 'tableSchmaID' => $tableShameID, 'options' => $options]])->$crudString;
        if (!$crudObject instanceof CrudInterface) {
            throw new CrudExceptions($crudString . ' is not a valid crud object!');
        }
        return self::$container->load([EntityManager::class => ['crud' => $crudObject]])->Entity;
    }

    /**
     * set Container
     * ========================================================================================
     * @param ContainerInterface $container
     * @return self
     */
    public function set_container(ContainerInterface $container) :self
    {
        $this->container = $container;
        return $this;
    }
}