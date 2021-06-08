<?php

declare(strict_types=1);

interface QueryBuilderInterface
{
    /**
      * --------------------------------------------------------------------------------------------------
      * Insert query
      * @return string
      */
    public function insert():string;

    /**
      * --------------------------------------------------------------------------------------------------
      * Select Query
      *@return string
     */
    public function select() : string;

    /**
     * --------------------------------------------------------------------------------------------------
     * update query
     * @return string
     */
    public function update() : string;

    /**
    * --------------------------------------------------------------------------------------------------
    * Delete query
    *@return string
    */
    public function delete() : string;

    /**
    * --------------------------------------------------------------------------------------------------
    * Search query
    *@return string
    */
    public function search() : string;

    /**
     * --------------------------------------------------------------------------------------------------
     * custom query
     * @return string
     */
    public function customQuery(): string;
}