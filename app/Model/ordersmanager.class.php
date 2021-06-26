<?php

class OrderssManager extends Model
{
    protected $_colID = 'ordID';
    protected $_table = 'orders';
    protected $_colIndex = 'userID';
    protected $_colContent = '';
    protected $_modelName;
    public $ordID;
    public $ord_number;
    public $ord_userID;
    public $ord_delivery_address;
    public $ord_invoice_address;
    public $ord_delivery_date;
    public $ord_amount;
    public $ord_qty;
    public $ord_status;
    public $created_at;
    public $updated_at;
    public $deleted;

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
    public function getHtmlData($item = [])
    {
        $template = file_get_contents(FILES . 'template' . DS . 'e_commerce' . DS . 'account' . DS . 'commandesTemplate.php');
        return [$template];
    }
}
