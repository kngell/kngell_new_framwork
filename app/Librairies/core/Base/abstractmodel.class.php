<?php

declare(strict_types=1);

abstract class AbstractModel extends Model
{
    /**
     * Prevent for deleting accidentally Ids
     *
     * @return array
     */
    abstract public function guardedIds() :array;
}