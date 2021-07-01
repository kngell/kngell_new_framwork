<?php
declare(strict_types=1);
class CreditCardManager extends Model
{
    protected string $_colID = 'ccID';
    protected string $_table = 'credit_card';
    protected string $_colIndex = 'userID';

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
    public function get_expiryDate(string $expiry)
    {
        if (!empty($expiry)) {
            $ex_date = explode('/', $expiry);
            $ex_date = '01-' . trim($ex_date[0]) . '-20' . trim($ex_date[1]);
            $format = 'd-m-Y';
            $date = DateTime::createFromFormat($format, $ex_date);
            return $date->format('Y-m-d H:i:s');
        }
    }

    //=======================================================================
    //Operations
    //=======================================================================
}