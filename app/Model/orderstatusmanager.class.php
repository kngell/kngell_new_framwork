<?php
declare(strict_types=1);
class OrderStatusManager extends Model
{
    protected $_colID = 'osID';
    protected $_table = 'order_status';
    protected $_colTitle = 'status';

    public function __construct()
    {
        parent::__construct($this->_table, $this->_colID);
        $this->_modelName = str_replace(' ', '', ucwords(str_replace('_', ' ', $this->_table))) . 'Manager';
    }

    public function get_fieldName(string $table = '') : string
    {
        switch ($table) {
            case 'orders':
                return 'ord_status';
                break;

            default:
                // code...
                break;
        }
    }
}