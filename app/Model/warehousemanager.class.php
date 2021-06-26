<?php

class WarehouseManager extends Model
{
    protected string $_colID = 'whID';
    protected string $_table = 'warehouse';
    protected string $_colTitle = 'wh_name';

    //=======================================================================
    //construct
    //=======================================================================
    public function __construct()
    {
        parent::__construct($this->_table, $this->_colID);
        // $this->_modelName = str_replace(' ', '', ucwords(str_replace('_', ' ', $this->_table))) . 'Manager';
    }

    //=======================================================================
    //Getters & setters
    //=======================================================================
    public function get_fieldName(string $table = '')
    {
        return 'p_warehouse';
    }

    //=======================================================================
    //Operations
    //=======================================================================
}