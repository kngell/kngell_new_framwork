<?php
declare(strict_types=1);
class GroupsManager extends Model
{
    protected string $_colID = 'grID';
    protected string $_table = 'groups';
    protected string $_colIndex = 'parentID';
    protected string $_colTitle = 'name';
    protected string $_colContent = '';

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

    // //Get selected options
    // public function get_selectedOptions()
    // {
    //     $selected_option = $this->parentID != '0' ? $this->getDetails($this->parentID, $this->_colID) : null;
    //     $colID = $this->_colID;
    //     $colTitle = $this->_colTitle;
    //     if ($selected_option) {
    //         $data[$selected_option->$colID] = $selected_option->$colTitle;
    //         return $data;
    //     }
    //     return [];
    // }

    public function get_successMessage($method = '', $params = [])
    {
        switch ($method) {
            case 'Add':
                return 'Groupe d\'utilisateur crée avec success';
                break;
            case 'update':
                return 'La group a été mise à jour.';
                break;

            default:
                return 'Group d\'utilisateur supprimé avec success!';
                break;
        }
    }

    //=======================================================================
    //Operations
    //=======================================================================

    // Insert
    public function beforeSave(array $params = [])
    {
        parent::beforeSave();
        if ($this->status == 'on') {
            $this->status = '1';
        }
        return true;
    }

    //delete
    //After delete categorie
    public function afterDelete($params = [])
    {
        $groups = $this->getAllbyIndex($params['id'])->get_results();
        if ($groups) {
            foreach ($groups as $group) {
                $group->parentID = '0';
                $colID = $group->get_colID();
                $group->id = $group->$colID;
                $group->save();
            }
        }
        return true;
    }

    public function get_fieldName(string $table = '')
    {
        return 'parentID';
    }
}