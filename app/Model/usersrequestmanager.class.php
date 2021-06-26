<?php

class UsersRequestsManager extends Model
{
    protected $_colID = 'urID';
    protected $_table = 'users_requests';
    protected $_colIndex = 'userID';
    protected $_modelName;
    public $urID;
    public $userID;
    public $hash;
    public $timestamp;
    public $type;
    public $created_at;
    public $updated_at;

    //=======================================================================
    //construct
    //=======================================================================
    public function __construct()
    {
        parent::__construct();
        $this->_modelName = str_replace(' ', '', ucwords(str_replace('_', ' ', $this->_table))) . 'Manager';
    }

    //=======================================================================
    //Getters & setters
    //=======================================================================

    //=======================================================================
    //Operations
    //=======================================================================
}
