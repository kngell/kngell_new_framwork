<?php

class WarehouseProductManager extends Model
{
    protected $_colID = 'whpID';
    protected $_table = 'warehouse_product';
    protected $_colIndex = 'whID';
    protected $_modelName;
    public $whID;
    public $productID;
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
