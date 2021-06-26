<?php

class ProductCategorieManager extends Model
{
    protected string $_colID = 'pcID';
    protected string $_table = 'product_categorie';
    protected string $_colIndex = 'pdtID';

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

    //=======================================================================
    //Operations
    //=======================================================================
}