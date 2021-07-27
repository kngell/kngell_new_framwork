<?php
declare(strict_types=1);
class UsersRelatedProfileManager extends Model
{
    protected string $_colID = 'urpID';
    protected string $_table = 'users_related_profile';

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
    public function afterSave($params = [])
    {
        $save_addr = $this->container->make(AddressBookManager::class)->partial_saveAddress($params, $this->_table, $this->get_lastID());
        if (array_key_exists('errors', $save_addr)) {
            $errors = $save_addr['errors'];
            unset($save_addr['errors']);
        }
        return ['save_addr' => $save_addr ?? [], 'errors' => $errors ?? []];
    }
}