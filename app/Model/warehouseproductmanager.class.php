<?php
declare(strict_types=1);
class WarehouseProductManager extends Model
{
    protected $_colID = 'whpID';
    protected $_table = 'warehouse_product';
    protected $_colIndex = 'whID';
    protected $_modelName;

    public function __construct()
    {
        parent::__construct($this->_table, $this->_colID);
        $this->_modelName = str_replace(' ', '', ucwords(str_replace('_', ' ', $this->_table))) . 'Manager';
    }
}