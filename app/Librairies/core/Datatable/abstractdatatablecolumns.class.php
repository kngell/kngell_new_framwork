<?php

declare(strict_types=1);

abstract class AbstractDatatableColumns implements DatatableColumnsInterface
{
    abstract public function columns() : array;
}