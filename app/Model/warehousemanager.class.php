<?php
declare(strict_types=1);
class WarehouseManager extends Model
{
    protected string $_colID = 'whID';
    protected string $_table = 'warehouse';
    protected string $_colTitle = 'wh_name';
    protected array  $select2_field = ['company', 'country_code'];

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
    public function get_fieldName(string $table = '')
    {
        return 'p_warehouse';
    }

    public function getAll() : ?array
    {
        $tables = ['table_join' => ['warehouse' => ['*'], 'company' => ['sigle', 'denomination']]];
        $data = ['join' => 'LEFT JOIN', 'rel' => [['company', 'compID']], 'return_mode' => 'class'];
        $wh = $this->getAllItem($data, $tables);
        return $wh->count() > 0 ? $wh->get_results() : [];
    }

    public function get_successMessage(string $method = '', string $params = '')
    {
        switch ($method) {
            case 'update':
                if ($params == 'custom_message') {
                    return FH::showMessage('success text-center', 'Entrepôt mis à jour ave succès');
                }
                return 'Profil mis a jour avec succès!';
                break;
            case 'delete':
                return 'Entrepôt supprimé !';
                break;
            default:
                return 'Entrepôt créee avec success!';
                break;
        }
    }

    //=======================================================================
    //Operations
    //=======================================================================
}