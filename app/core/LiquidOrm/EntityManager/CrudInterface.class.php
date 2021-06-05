<?php

declare(strict_types=1);

interface CrudInterface
{
    /**
      * --------------------------------------------------------------------------------------------------
      * Get Data base name
      * @return string
      */
    public function getSchema():String;

    /**
      * --------------------------------------------------------------------------------------------------
      * Get Primary Key
      * @return string
      */
    public function getSchemaID():String;

    /**
     * --------------------------------------------------------------------------------------------------
     * Get Last Insert ID
     * @return int
     */
    public function lastID():Int;

    /**
     * --------------------------------------------------------------------------------------------------
     * Insert in data base successfully or not
     * @param array $fields
     * @return bool
     */
    public function create(array $fields):bool;

    /**
     * --------------------------------------------------------------------------------------------------
     * Read data from data base
     * @param array $selectors
     * @param array $conditions
     * @param array $params
     * @param array $options
     * @return array
     */
    public function read(array $selectors = [], array $conditions = [], array $params = [], array $options = []):array;

    /**
     * --------------------------------------------------------------------------------------------------
     * Update data
     * @param array $fields
     * @return bool
     */
    public function update(array $fields = [], string $primary_key):bool;

    /**
    * --------------------------------------------------------------------------------------------------
    * Delete data
    * @param array $conditions
    * @return bool
    */
    public function delete(array $conditions = []):bool;

    /**
    * --------------------------------------------------------------------------------------------------
    * Search data
    * @param array $selectors
    * @param array $searchconditions
    * @return array
    */
    public function search(array $selectors = [], array $searchconditions = []):array;

    /**
    * --------------------------------------------------------------------------------------------------
    * Custom Data
    * @param array $query
    * @param array $conditions
    * @return void
    */
    public function customQuery(string $query = [], array $conditions = []);
}
