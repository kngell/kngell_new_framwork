<?php

declare(strict_types=1);

interface DataMapperInterface
{
    /**
      * --------------------------------------------------------------------------------------------------
      * Prepare the query string
      * @param string $sql
      * @return self
      */
    public function prepare(string $sql):self;

    /**
      * --------------------------------------------------------------------------------------------------
      * Explicit datatype for bind PDO
      *@param mixed $value
      *@return mixed
     */
    public function bind_type($value);

    /**
     * --------------------------------------------------------------------------------------------------
     * Binding the given values of the query
     * @param $param
     * @param $value
     * @param null $type
     */
    public function bind($param, $value, $type = null);

    /**
    * --------------------------------------------------------------------------------------------------
    * combinaition method wich combines bind type and values
    *@param array $fields
    *@param bool $isSearch
    *@return self
    */
    public function bindParameters(array $fields = [], bool $isSearch = false) : self;

    /**
     * --------------------------------------------------------------------------------------------------
     * Return number of rows
     * @return int
     */
    public function numrow(): int;

    /**
     * --------------------------------------------------------------------------------------------------
     * Execute prepare statement
     * @return void
    */
    public function execute(): void;

    /**
     * --------------------------------------------------------------------------------------------------
     * Return sigle object result
     *@return Object
    */
    public function result(): Object;

    /**
     * --------------------------------------------------------------------------------------------------
     * Return all
     * @return array
    */
    public function results(): array;

    /**
     * --------------------------------------------------------------------------------------------------
     * Get las insert ID
     * @return int
     * @throws throwable
    */
    public function getLasID(): int;
}
