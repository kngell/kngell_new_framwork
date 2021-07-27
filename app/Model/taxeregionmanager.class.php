<?php
declare(strict_types=1);
class TaxeRegionManager extends Model
{
    protected $_colID = 'trID';
    protected $_table = 'taxe_region';
    protected $_colTitle = 'tr_rate';
    protected $_colIndex = 'tr_country_code';

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
}