<?php
declare(strict_types=1);
class GroupUserManager extends Model
{
    protected string $_colID = 'gruID';
    protected string $_table = 'group_user';
    protected string $_colIndex = 'userID';

    //=======================================================================
    //construct
    //=======================================================================
    public function __construct()
    {
        parent::__construct($this->_table, $this->_colID);
        $this->_modelName = str_replace(' ', '', ucwords(str_replace('_', ' ', $this->_table))) . 'Manager';
    }

    //=======================================================================
    //Getters & setters
    //=======================================================================

    //=======================================================================
    //Operations
    //=======================================================================
}