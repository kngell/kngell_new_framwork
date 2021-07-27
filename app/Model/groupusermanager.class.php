<?php
declare(strict_types=1);
class GroupUserManager extends Model
{
    protected string $_colID = 'gruID';
    protected string $_table = 'group_user';
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

    //=======================================================================
    //Operations
    //=======================================================================
    public function createUserRole(int $role = -1, int $userID = -1) : bool
    {
        $user_role = $this->getAllItem(['where' => ['userID' => $userID, 'groupID' => $role], 'return_mode' => 'class']);
        if ($user_role->count() > 0) {
            return true;
        }
        if (!($role < 0) && !($userID < 0)) {
            $this->userID = $userID;
            $this->groupID = $role;
            if (!$this->save()) {
                return false;
            }
        }
        return true;
    }
}