<?php

declare(strict_types=1);
class UserEntity extends BaseEntity
{
    /**
     * Main constructor to Sanitize data
     *
     * @param array $dirtyData
     */
    public function __construct(array $dirtyData)
    {
        parent::__construct($dirtyData);
    }
}