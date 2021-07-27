<?php
declare(strict_types=1);
class UsersManager extends Model
{
    protected string $_colID = 'userID';
    protected string $_table = 'users';
    protected string $_colIndex = 'userID';
    protected string $deleted;

    //=======================================================================
    //construct
    //=======================================================================

    public function __construct()
    {
        parent::__construct($this->_table, $this->_colID);
    }

    //=======================================================================
    //Manage users
    //=======================================================================
    //Get Select2 fields Names
    public function get_fieldName(string $table = '')
    {
        switch ($table) {
            case 'orders':
                return 'ord_userID';
                break;

            default:
                return 'group';
                break;
        }
    }

    // Get single user Data
    public function get_single_user($id)
    {
        $tables = ['table_join' => ['users' => ['*'], 'user_extra_data' => ['*'], 'address_book' => ['*']]];
        $data = [
            'join' => 'LEFT JOIN',
            'rel' => [
                ['userID', 'userID'],
                [['value' => 'userID', 'tbl' => 'users'], 'relID'],
                'params' => ['relID| = ' . $id . '|address_book', 'tbl| = "' . $this->_table . '"|address_book']
            ],
            'where' => ['userID' => ['value' => $id, 'tbl' => 'users']
            ],
            'return_mode' => 'class',
            //'class_args' => [$this->form]
        ];
        $user = $this->getAllItem($data, $tables)->get_results();
        return $user ? current($user) : null;
    }

    // Get All Users
    public function get_users($method, $offset = '', $limit = '', $html = true)
    {
        $tables = ['table_join' => ['groups' => ['*'], 'group_user' => ['userID']]];
        $data = ['join' => 'INNER JOIN', 'rel' => [['grID', 'groupID']], 'where' => ['name' => ['value' => 'admin', 'tbl' => 'groups']], 'return_mode' => 'class'];
        $admin_group = $this->container->make(GroupsManager::class)->getAllItem($data, $tables)->get_results();
        switch ($method) {
            case 'get_adminUsers':
                $this->_deleted_item = false;
                $textClass = 'text-danger';
                $where = $admin_group ? ['where' => ['groupID' => ['value' => array_column($admin_group, 'grID'), 'operator' => 'IN', 'tbl' => 'group_user']]] : [];
                $style_restore = 'style="display:none"';
                $style_edit = '';
                break;
            case 'get_deletedUsers':
                $this->_deleted_item = true;
                $textClass = 'text-secondary';
                $style_restore = '';
                $style_edit = 'style="display:none"';
                break;
            default:
                $this->_deleted_item = false;
                $textClass = 'text-danger';
                $where = $admin_group ? ['where' => ['userID' => ['value' => array_column($admin_group, 'userID'), 'operator' => 'NOT IN', 'tbl' => 'users']]] : [];
                $style_restore = 'style="display:none"';
                $style_edit = '';
                break;
        }

        $tables = ['table_join' => ['users' => ['*'], 'group_user' => ['groupID']]];
        $data = isset($where) && !empty($where) ? array_merge(['join' => 'LEFT JOIN', 'rel' => [['userID', 'userID']], 'group_by' => 'userID DESC'], $where, ['return_mode' => 'class']) : ['join' => 'LEFT JOIN', 'rel' => [['userID', 'userID']], 'group_by' => 'userID DESC', 'return_mode' => 'class'];
        $params = !empty($limit) ? ['offset' => $offset, 'limit' => $limit] : [];
        $users = $this->getAllItem($data, $tables, $params)->get_results();
        $btn = [$textClass, $method, $style_restore, $style_edit];
        $admin_group = null;
        return $html ? $this->output_users($users, $btn) : count($users);
    }

    //output users
    public function output_users($users, $btn = [])
    {
        $output = '';
        if ($users && is_array($users)) {
            foreach ($users as $user) {
                $template = file_get_contents(FILES . 'template' . DS . 'admin' . DS . 'users.php');
                $template = $this->output_userData($user, $template, $btn);
                $template = $this->output_userExtraData($user, $template);
                $output .= $template;
            }
        } elseif ($users) {
            $template = file_get_contents(FILES . 'template' . DS . 'admin' . DS . 'users.php');
            $template = $this->output_userData($users, $template);
            $template = $this->output_userExtraData($users, $template);
            $output .= $template;
        }
        $users = null;
        $template = '';
        return $output;
    }

    //output users data
    public function output_userData($user = null, $temp = '', $btn = '')
    {
        $template = $temp;
        $template = str_replace('{{firstname}}', $user->firstName ?? '', $template);
        $template = str_replace('{{lastname}}', $user->lastName ?? '', $template);
        $template = str_replace('{{userID}}', strval($user->userID), $template);
        $template = str_replace('{{method}}', $btn[1] ?? '', $template);
        $template = str_replace('{{style_restore}}', $btn[2] ?? '', $template);
        $template = str_replace('{{style_edit}}', $btn[3] ?? '', $template);
        $template = str_replace('{{image}}', ImageManager::asset_img(!empty(unserialize($user->profileImage)[0]) ? unserialize($user->profileImage)[0] : 'users' . DS . 'avatar.png'), $template);
        $template = str_replace('{{phone}}', $user->phone ?? '', $template);
        $template = str_replace('{{delBtnClass}}', $btn[0] ?? '', $template);
        $template = str_replace('{{users_profile}}', PROOT . 'admin' . US . 'profile' . US . $user->userID, $template);
        $template = str_replace('{{token_d}}', FH::csrfInput('csrftoken', $this->container->make(Token::class)->generate_token(8, 'delete_user' . $user->userID)), $template);
        $template = str_replace('{{token_r}}', FH::csrfInput('csrftoken', $this->container->make(Token::class)->generate_token(8, 'restore_user' . $user->userID)), $template);
        $template = str_replace('{{token_e}}', FH::csrfInput('csrftoken', $this->container->make(Token::class)->generate_token(8, 'edit-user-frm' . $user->userID)), $template);
        return $template;
    }

    //output users extradata
    public function output_userExtraData($m = null, $temp = '')
    {
        $extra_data = $this->container->make(UserExtraDataManager::class)->getDetails($m->userID, 'userID');
        $template = $temp;
        $template = str_replace('{{function}}', $extra_data->u_function ?? '', $template);
        $template = str_replace('{{address}}', $extra_data->u_address ?? '', $template);
        $extra_data = null;
        return $template;
    }

    // After find a user manage image profile
    public function afterFind($m = null)
    {
        if ($m->count() === 1) {
            $model = current($m->get_results());
            $model->profileImage = unserialize($model->profileImage)[0] != '' ? unserialize($model->profileImage)[0] : 'users/avatar.png';
            $m->get_results()[0] = $model;
        }
        return $m;
    }

    //=======================================================================
    //Manage deleted users
    //=======================================================================

    public function beforeDelete($params = [])
    {
        if (isset($params['method'])) {
            switch ($params['method']) {
                case 'delete_user':
                    $this->set_SoftDelete(false);
                    break;
                case 'restore_user':
                    $this->set_SoftDelete(true);
                    $params['restore'] = ['deleted' => 0];
                    break;
                default:
                    $this->set_SoftDelete(true);
                    break;
            }
        } else {
            $this->set_SoftDelete(true);
        }
        return $params;
    }

    //=======================================================================
    //Get User form Template
    //=======================================================================
    public function getHtmlData($item = [])
    {
        $template = file_get_contents(FILES . 'template' . DS . 'e_commerce' . DS . 'account' . DS . 'userTemplate.php');
        $user = $this->get_single_user($item['id']);
        return $this->output_users_account_overview($template, $user);
    }

    // output account overview data
    public function output_users_account_overview($temp = '', $user = null)
    {
        $template = $temp;
        $template = str_replace('{{nom}}', $user->firstName ?? '' . '&nbsp;' . $user->lastName ?? '', $template);
        $template = str_replace('{{email}}', $user->email ?? '', $template);
        $template = str_replace(' {{csrftoken}}', FH::csrfInput('csrftoken', (new Token())->generate_token(8)), $template);
        $template = str_replace('{{firstName}}', $user->firstName ?? '', $template);
        $template = str_replace('{{lastName}}', $user->lastName ?? '', $template);
        $template = str_replace('{{userID}}', AuthManager::$currentLoggedInUser->userID, $template);
        $template = str_replace('{{registerDate}}', AuthManager::$currentLoggedInUser->registerDate, $template);
        $template = str_replace('{{updateAt}}', AuthManager::$currentLoggedInUser->updateAt, $template);
        $template = str_replace('{{profileImage}}', $user->profileImage ? IMG . unserialize($user->profileImage)[0] : IMG . 'users' . US . 'avatar.png', $template);
        $template = str_replace('{{deleted}}', AuthManager::$currentLoggedInUser->deleted, $template);
        $template = str_replace('{{profession}}', $user->u_function ?? '', $template);
        $template = str_replace('{{usdID}}', $user->usdID, $template);
        $template = str_replace('{{phone}}', $user->phone ?? '', $template);
        $template = str_replace('{{address}}', $this->htmlDecode($user->address) ?? '', $template);
        $template = str_replace('{{ville}}', $this->htmlDecode($user->ville) ?? '', $template);
        $template = str_replace('{{region}}', $this->htmlDecode($user->region) ?? '', $template);
        $template = str_replace('{{zip_code}}', $this->htmlDecode($user->zip_code) ?? '', $template);
        $template = str_replace('{{checked}}', $user->principale == 'on' ? 'checked' : '', $template);
        $template = str_replace('{{gender}}', $user->gender ?? '', $template);
        $template = str_replace('{{u_descr}}', $user->u_descr ?? '', $template);
        $template = str_replace('{{dob}}', $user->dob ?? '', $template);
        return [$template, $this->get_countrie($user->pays)];
    }

    //=======================================================================
    //Set users permissions
    //=======================================================================
    // On insert
    public function afterSave($params = [])
    {
        $saveID = isset($params['saveID']) ? $params['saveID'] : null;
        unset($params['saveID']);
        if (!empty($params)) {
            $saveID->errors = [];
            if (isset($params['group'])) {
                $select2_data = json_decode($this->htmlDecode($params['group']), true);
                if ($select2_data ? !$this->saveUserGroup($select2_data, $saveID->get_lastID() ?? $params['userID']) : '') {
                    $saveID->errors['group'] = true;
                }
            }
            // Manage default adresse
            if (!isset($params['principale'])) {
                $params['principale'] = null;
            }
            //save address
            $saveID->save_addr = $this->container->make(AddressBookManager::class)->partial_saveAddress($params, $this->_table, $this->id ?? $this->get_lastID());

            // save user extra data
            if ($ud = $this->get_user_extra_data($params)) {
                $init_val = [
                    'userID' => $this->id ?? $this->get_lastID(),
                ];
                $saveID->u_extra = $this->partial_save($ud, ['where' => ['userID' => $this->id ?? $this->get_lastID()], 'return_mode' => 'class'], 'user_extra_data', $init_val);
            }
            if (is_array($saveID->save_addr) && array_key_exists('errors', $saveID->save_addr)) {
                $saveID->errors = array_merge($saveID->errors, $saveID->save_addr['errors']);
                unset($saveID->save_addr['errors']);
            }
            return $saveID;
        }
    }

    //get user extra data fields
    private function get_user_extra_data($params)
    {
        $this;
        $ux = [];
        $ux['u_descr'] = isset($params['u_descr']) ? $params['u_descr'] : '';
        $ux['gender'] = isset($params['gender']) ? $params['gender'] : '';
        $ux['dob'] = isset($params['dob']) ? $params['dob'] : '';
        $ux['u_function'] = isset($params['u_function']) ? $params['u_function'] : '';
        $ux['u_comment'] = isset($params['u_comment']) ? $params['u_comment'] : '';
        $ux['u_total_spend'] = isset($params['u_total_spend']) ? $params['u_total_spend'] : '';
        foreach ($ux as $param) {
            if (empty($param)) {
                continue;
            } else {
                return $ux;
            }
        }
        return false;
    }

    //Save user permission group
    public function saveUserGroup($params = [], $userID = '')
    {
        $user_roles = $this->container->make(GroupUserManager::class)->getAllItem(['where' => ['userID' => $userID], 'return_mode' => 'class']);
        $error = false;
        $groupID = false;
        if ($user_roles->count() >= 1) {
            foreach ($user_roles->get_results() as $role) {
                if (!$role->delete()) {
                    $error = true;
                    break;
                }
            }
        }
        if ($params && count($params) > 0) {
            foreach ($params as $role) {
                $user_group = $this->container->make(GroupsManager::class)->getAllItem(['where' => ['name' => strtolower($role['text'])], 'return_mode' => 'class']);
                if ($user_group->count() <= 0) {
                    $user_group->name = strtolower($role['text']);
                    $groupID = $user_group->save();
                }
                $user_roles->userID = $userID;
                $user_roles->groupID = $user_group->count() > 0 ? current($user_group->get_results())->grID : $groupID['saveID']->get_lastID();
                if (!$user_roles->save()) {
                    $error = true;
                }
                $user_group = null;
            }
        }
        $user_roles = null;

        return $error ;
    }

    //get selected option
    public function get_selectedOptions(Object $m = null)
    {
        $tables = ['table_join' => ['groups' => ['*'], 'group_user' => ['userID', 'groupID']]];
        $data = ['join' => 'INNER JOIN',
            'rel' => [['grID', 'groupID']],
            'where' => ['userID' => $m->userID],
            'return_mode' => 'class'
        ];
        $user_roles = $this->container->make(GroupUserManager::class)->getAllItem($data, $tables);
        $response = [];
        if ($user_roles->count() >= 1) {
            foreach ($user_roles->get_results() as $role) {
                $response[$role->groupID] = $role->name;
            }
        }
        $user_roles = null;
        return $response ? $response : [];
    }

    public function get_successMessage(string $method = '', array $params = [])
    {
        switch ($method) {
            case 'update':
                if ($params == 'custom_message') {
                    return FH::showMessage('success text-center', 'Profil mis à jour ave succès');
                }
                return 'Profil mis a jour avec succès!';
                break;
            case 'delete':
                if (isset($params['method']) && $params['method'] == 'restore_user') {
                    return 'Utilisateur restauré avec succès!';
                } elseif (isset($params['method']) && $params['method'] == 'delete_user') {
                    return 'Utilisateur Supprimé!';
                } else {
                    return 'message non défini !';
                }
                break;
            default:
                return 'Utilisateur créee avec success!';
                break;
        }
    }
}