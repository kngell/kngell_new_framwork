<?php

declare(strict_types=1);

class QueryBuilderFactory
{
    protected static ContainerInterface $container;

    /**
     * =====================================================================
     * Main constructor
     * =====================================================================
     *@return void
     */
    public function __construct()
    {
    }

    /**
     * Create factory
     * ========================================================================================
     *@return QueryBuilderInterface
     */
    public function create(string $querybuiderString) : QueryBuilderInterface
    {
        $querybuilderObject = self::$container->load([$querybuiderString => []])->$querybuiderString;
        if (!$querybuilderObject instanceof QueryBuilderInterface) {
            throw new QueryBuilderExceptions($querybuiderString . ' is not a valid query builder!');
        }
        return $querybuilderObject;
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