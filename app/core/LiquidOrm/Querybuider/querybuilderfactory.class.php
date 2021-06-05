<?php

declare(strict_types=1);

class QueryBuilderFactory
{
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
     * =====================================================================
     * Create factory
     * =====================================================================
     *@return QueryBuilderInterface
     */
    public function create(string $querybuiderString) : QueryBuilderInterface
    {
        $querybuilderObject = new $querybuiderString();
        if (!$querybuilderObject instanceof QueryBuilderInterface) {
            throw new QueryBuilderExceptions($querybuiderString . ' is not a valid query builder!');
        }
        return $querybuilderObject;
    }
}
