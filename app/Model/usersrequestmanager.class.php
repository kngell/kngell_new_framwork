<?php
declare(strict_types=1);
class UsersRequestsManager extends Model
{
    protected $_colID = 'urID';
    protected $_table = 'users_requests';
    protected $_colIndex = 'userID';

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