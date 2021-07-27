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

    protected ContainerInterface $container;

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
        $this->set_container();
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
        $crudObject = $this->container->bind($crudString, fn () => new $crudString($this->datamapper, $this->querybuilder, $tableSchma, $tableShameID, $options))->make($crudString);
        if (!$crudObject instanceof CrudInterface) {
            throw new CrudExceptions($crudString . ' is not a valid crud object!');
        }
        $this->container->bind(CrudInterface::class, fn () => $crudObject);
        return $this->container->bind(EntityManager::class)->make(EntityManager::class);
    }

    /**
     * set Container
     * ========================================================================================
     * @param ContainerInterface $container
     * @return self
     */
    public function set_container() :self
    {
        if (!isset($this->container)) {
            $this->container = Container::getInstance();
        }
        return $this;
    }
}