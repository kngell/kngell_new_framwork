<?php

class OrderDetailsManager extends Model
{
    protected $_colID = 'odID';
    protected $_table = 'order_details';
    protected $_colIndex = 'od_productID';
    protected $_modelName;
    public $odID;
    public $od_warehouseID; // Warehouse
    public $od_productID;
    public $od_unitID;
    public $od_packing_size;
    public $od_quantity;
    public $od_amount;
    public $od_purchase_type;
    public $purchase_type;
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
