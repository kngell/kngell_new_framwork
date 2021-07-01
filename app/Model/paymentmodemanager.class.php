<?php

class PaymentModeManager extends Model
{
    protected string $_colID = 'pmID';
    protected string $_table = 'payment_mode';

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
    public function getHtmlData($item = [])
    {
        $template = file_get_contents(FILES . 'template' . DS . 'e_commerce' . DS . 'account' . DS . 'paiementsTemplate.php');
        return [$template];
    }
}