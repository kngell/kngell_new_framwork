<?php

declare(strict_types=1);
class UsersManager extends AbstractModel
{
    protected const COLID = 'userID';
    protected const TABLE = 'users';

    /**
     * Main construtor, required table and colID
     */
    public function __construct()
    {
        parent::__construct(self::TABLE, self::COLID);
    }

    /**
     * Prevent deliting Ids
     *
     * @return array
     */
    public function guardedIds() : array
    {
        return [];
    }
}