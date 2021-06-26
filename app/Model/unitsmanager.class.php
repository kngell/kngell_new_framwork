<?php

class UnitsManager extends Model
{
    protected string $_colID = 'unID';
    protected string $_table = 'units';
    protected string $_colTitle = 'unit';
    protected array $checkboxes = ['status'];
    protected array $select2_field = ['unit'];

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
    public function get_successMessage($method = '', $action = '')
    {
        switch ($method) {
            case 'Add':
                return 'Unité de mesure crée avec success!';
                break;
            case 'update':
                return 'L\'unité de mesure mise à jour avec success!';
                break;
            case 'delete':
                return 'L\'unité a été supprimée avec success!';
                break;

            default:
                return 'Votre requête est bien prise en compte!';
                break;
        }
    }

    //Get Select2 fields Names
    public function get_fieldName(string $table = '')
    {
        return 'unit';
    }
}