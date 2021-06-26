<?php
declare(strict_types=1);
class BrandManager extends Model
{
    protected string $_colID = 'brID';
    protected string $_table = 'brand';
    protected string $_colTitle = 'br_name';
    protected array $checkboxes = ['status'];

    /**
     * Main constructor
     * =======================================================================
     */
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
            case 'update':
                return 'Branche mise a jour avec success!';
                break;
            case 'delete':
                return 'Branche supprimée!!';
                break;
            case 'Add':
                return 'Branche ajoutée avec success!!';
                break;

            default:
                return 'votre requête est bien prise en compte!';
                break;
        }
    }

    public function get_fieldName(string $table = '')
    {
        switch ($table) {
            case 'categories':
                return 'brID';
                break;

            default:
                return 'categorie';
                break;
        }
    }

    //=======================================================================
    //Operations
    //=======================================================================
}