<?php

declare(strict_types=1);

interface DataRepositoryInterface
{
    /**
    * Create or inert into a database
    * --------------------------------------------------------------------------------------------------
    * @param array $fields
    * @return integer|null
    */
    public function create(array $fields) : ?int;

    /**
     * Delete from database
     * --------------------------------------------------------------------------------------------------
     * @param array $conditions
     * @return int|null
     */
    public function delete(array $conditions) : ?int;

    /**
     * --------------------------------------------------------------------------------------------------
     * Find by ID
     * @param integer $id
     * @return array
     */
    public function findByID(int $id) :array;

    public function findAll() :array;

    /**
     * find By
     * --------------------------------------------------------------------------------------------------
     * @param array $selectors
     * @param array $conditions
     * @param array $parameters
     * @param array $options
     * @return mixed
     */
    public function findBy(array $selectors = [], array $conditions = [], array $parameters = [], array $options = []);

    /**
     * Find One by
     *--------------------------------------------------------------------------------------------------
     * @param array $conditions
     * @param array $options
     * @return mixed
     */
    public function findOneBy(array $conditions, array $options) : mixed;

    /**
     * Find Object
     *--------------------------------------------------------------------------------------------------
     * @param array $conditions
     * @param array $selectors
     * @return Object
     */
    public function findObjectBy(array $conditions = [], array $selectors = []) : Object;

    /**
     * Search data
     *--------------------------------------------------------------------------------------------------
     * @param array $selectors
     * @param array $conditions
     * @param array $parameters
     * @param array $options
     * @return array
     */
    public function findBySearch(array $selectors = [], array $conditions = [], array $parameters = [], array $options = []) :array;

    /**
     * Find by Id and Delete
     *--------------------------------------------------------------------------------------------------
     * @param array $conditions
     * @return boolean
     */
    public function findByIDAndDelete(array $conditions) :bool;

    /**
     * Find by id and update
     *--------------------------------------------------------------------------------------------------
     * @param array $fields
     * @param integer $id
     * @return boolean
     */
    public function findByIdAndUpdate(array $fields = [], int $id = 0) : bool;

    /**
     * Search data with pagination
     *--------------------------------------------------------------------------------------------------
     * @param array $args
     * @param object $request
     * @return array
     */
    public function findWithSearchAndPagin(Object $request, array $args) : array;

    /**
     * find and return self for chanability
     *--------------------------------------------------------------------------------------------------
     * @param integer $id
     * @param array $selectors
     * @return self
     */
    public function findAndReturn(int $id, array $selectors = []) : self;

    /**
     * Get Table columns
     *
     * @param array $options
     * @return object
     */
    public function get_tableColumn(array $options): object;
}