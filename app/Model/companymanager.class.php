<?php
declare(strict_types=1);
class CompanyManager extends Model
{
    protected string $_colID = 'compID';
    protected string $_table = 'company';
    protected string $_colTitle = 'denomination';

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
    public function get_successMessage($method = '', $data = [])
    {
        switch ($method) {
            case 'update':
                return 'Compagnie mis a jour avec success!';
                break;
            case 'delete':
                return 'Compagnie Supprimé!';
                break;
            default:
                return 'Compagnie créee avec success!';
                break;
        }
    }

    public function getCompanyName($name = false)
    {
        return htmlspecialchars_decode(html_entity_decode($name ?? $this->denomination), ENT_QUOTES);
    }

    // Get All addresses
    public function getAllAddress($id)
    {
        $params = ['where' => ['relID' => $id], 'return_mode' => 'class'];
        return !empty($id) ? $this->container->make(AddressBookManager::class)->getAllItem($params)->get_results() : [];
    }

    //Output address html
    public function getCompanyAddressHtml($data)
    {
        if ($data && count($data) > 0) {
            $addhtml = '';
            foreach ($data as $add) {
                $addressTemplate = file_get_contents(FILES . 'template' . DS . 'admin' . DS . 'companyaddressTemplate.php');
                $addressTemplate = str_replace('{{address}}', strval($add->address1), $addressTemplate);
                $addressTemplate = str_replace('{{zip_code}}', $add->zip_code, $addressTemplate);
                $addressTemplate = str_replace('{{ville}}', $add->ville, $addressTemplate);
                $addressTemplate = str_replace('{{pays}}', $add->pays, $addressTemplate);
                $addhtml .= $addressTemplate;
            }
            return $addhtml;
        }
        return '';
    }

    //=======================================================================
    //Operations
    //=======================================================================

    //save addresse
    public function afterSave(array $params = [])
    {
        $add = $this->container->make(AddressBookManager::class)->getDetails($params['saveID']->abID);
        if ($add->count() === 1) {
            $add = current($add->get_results());
            $colID = $add->get_colID();
            $add->id = $add->$colID;
        }
        $add = $add->assign($params);
        $add->tbl = $this->_table;
        $colID = $this->get_colID();
        $add->relID = empty($this->$colID) ? $params['saveID']->get_lastID() : $this->$colID;
        if (!$add->save()) {
            return false;
        }
        $add = null;
        return $params;
    }

    // After Deleted
    public function afterDelete($params = [])
    {
        $data = ['where' => ['relID' => $params[$this->get_colID()], 'tbl' => $this->_table]];
        return $params[$this->get_colID()] ? $this->container->make(AddressBookManager::class)->delete('', $data) : false;
    }

    //Get Details company
    public function getDetails(mixed $id, string $colID = '') :?self
    {
        $tables = ['table_join' => ['company' => ['*'], 'address_book' => ['*']]];
        $params = ['join' => 'LEFT JOIN',
            'rel' => [['compID', 'relID']],
            'where' => [$this->get_colID() => $id],
            'return_mode' => 'class',
            'group_by' => 'compID'
        ];
        $companies = array_filter($this->getAllItem($params, $tables)->get_results(), function ($comp) {
            if ($comp->get_tableName() == $this->_table) {
                $comp->sigle = $this->getCompanyName($comp->sigle) ;
                $comp->denomination = $this->getCompanyName($comp->denomination);
                return $comp;
            }
        });
        if ($companies && count($companies) > 0) {
            $this->_results = $companies;
            $this->_count = count($companies);
            return $this;
        }
        return null;
    }

    public function get_fieldName(string $table = '')
    {
        switch ($table) {
            case 'warehouse':
                return 'company';
                break;

            default:
                return 'p_company';
                break;
        }
    }

    public function beforeSaveUpadate(array $params = [])
    {
        $columns = $this->get_tableColumn();
        $fields = [];
        foreach ($columns as $column) {
            if (isset($params[$column])) {
                $fields[$column] = $params[$column];
            }
        }
        return parent::beforeSaveUpadate($fields);
    }

    public function get_colOptions($table)
    {
        switch ($table) {
            case 'products':
                return 'p_company';
                break;
            case 'products':
                return 'p_warehouse';
                break;

            default:
                return 'company';
                break;
        }
    }
}