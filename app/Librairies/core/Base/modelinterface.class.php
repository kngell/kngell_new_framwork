<?php

declare(strict_types=1);

interface ModelInterface
{
    /**
     * Get All Items
     * --------------------------------------------------------------------------------------------------
     * @param array $data
     * @param array $params
     * @param array $tables
     * @return self|Null
     */
    public function getAllItem(array $data = [], array $tables = [], array $params = []) : ?self;

    /**
     * Count num rows
     * --------------------------------------------------------------------------------------------------
     * @return void
     */
    public function count();

    /**
     * Get String décode
     * --------------------------------------------------------------------------------------------------
     * @param string $str
     * @return string
     */
    public function htmlDecode(string $str) : string;

    /**
     * Get Details Values
     * --------------------------------------------------------------------------------------------------
     * @param mixed $id
     * @param string $colID
     * @return void
     */
    public function getDetails(mixed $id, string $colID = '') : ?self;

    /**
     * Get By Index
     * --------------------------------------------------------------------------------------------------
     * @param string $index_value
     * @param array $params
     * @param array $tables
     * @return self|Null
     */
    public function getAllbyIndex(string $index_value, array $params = [], array $tables = []) : ?self;

    /**
     * Save data by update or insert
     * --------------------------------------------------------------------------------------------------
     * @param array $params
     * @return mixed
     */
    public function save(array $params = []);

    /**
     * Get repository data results
     * --------------------------------------------------------------------------------------------------
     * @return mixed
     */
    public function get_results() : mixed;
}