<?php

class PaymentsModeManager extends Model
{
    protected $_colID = 'pmID';
    protected $_table = 'payments_mode';
    protected $_colIndex = 'userID';
    protected $_colContent = '';
    protected $_modelName;
    public $pmID;
    public $userID;
    public $cc_type;
    public $cc_name;
    public $cc_number;
    public $cc_expiry;
    public $cc_cvv;
    public $date_enreg;
    public $updateat;
    public $deleted;
    public $status;

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
        $template = file_get_contents(FILES . 'template' . DS . 'e_commerce' . DS . 'account' . DS . 'paiementsTemplate.php');
        return [$template];
    }
}
