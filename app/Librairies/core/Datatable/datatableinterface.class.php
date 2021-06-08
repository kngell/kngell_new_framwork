<?php

declare(strict_types=1);
interface DatatableInterface
{
    /**
     * Create method
     * --------------------------------------------------------------------------------------------------
     * @param string $datacolumnString
     * @param array $datarepository
     * @param array $sortcontrollerArg
     * @return self
     */
    public function create(string $datacolumnString, array $datarepository, array $sortcontrollerArg) : self;

    /**
     * Undocumented function
     * --------------------------------------------------------------------------------------------------
     * @return string|null
     */
    public function table() : ?string ;

    /**
     * Undocumented function
     * --------------------------------------------------------------------------------------------------
     * @return string|null
     */
    public function pagination() : ?string;
}