<?php

class ShippingClassManager extends Model
{
    protected string $_colID = 'shcID';
    protected string $_table = 'shipping_class';
    protected string $_colTitle = 'sh_name';
    protected array $select2_field = ['sh_name'];

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
    public function get_successMessage($method = '', $action = '')
    {
        switch ($method) {
            case 'update':
                return 'Classe de livraison mise a jour avec success!';
                break;
            case 'delete':
                return 'Classe de livraison supprimée!!';
                break;
            case 'Add':
                return 'Classe de livraison ajoutée avec success!!';
                break;

            default:
                return 'votre requête est bien prise en compte!';
                break;
        }
    }

    //Get Select2 fields Names
    public function get_fieldName(string $table = '')
    {
        return 'sh_name';
    }

    //=======================================================================
    //Operations
    //=======================================================================
}