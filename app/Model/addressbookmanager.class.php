<?php
declare(strict_types=1);
class AddressBookManager extends Model
{
    protected $_colID = 'abID';
    protected $_table = 'address_book';
    protected $_colIndex = 'table';
    protected $_colContent = '';

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
    public function get_userAddress()
    {
        $tables = ['table_join' => ['users' => ['firstName', 'lastName', 'phone'], 'address_book' => ['*']]];
        $data = [
            'join' => 'LEFT JOIN',
            'rel' => [['userID', 'relID']],
            'where' => ['tbl' => ['value' => 'users', 'tbl' => 'address_book'], 'userID' => AuthManager::$currentLoggedInUser->userID],
            'return_mode' => 'class'
        ];
        $uc = $this->getAllItem($data, $tables);
        return $uc->count() > 0 ? $uc->get_results() : [];
    }

    /**
     * Output address Content for Template
     * ========================================================================
     * @return string
     */
    public function get_userAddressHtml(array $params = []) : string
    {
        $adds = empty($params) ? $this->get_userAddress() : $params;
        $output = '';
        if (!empty($adds)) {
            foreach ($adds as $add) {
                $template = file_get_contents(FILES . 'template' . DS . 'e_commerce' . DS . 'account' . DS . 'addressTemplateContent.php');
                $template = str_replace('{{prenom}}', $add->firstName ?? AuthManager::$currentLoggedInUser->firstName, $template);
                $template = str_replace('{{nom}}', $add->lastName ?? AuthManager::$currentLoggedInUser->lastName, $template);
                $template = str_replace('{{address}}', $this->htmlDecode($add->address1 ?? '') . ' ' . $this->htmlDecode($add->address2 ?? ''), $template);
                $template = str_replace('{{code_postal}}', $add->zip_code, $template);
                $template = str_replace('{{ville}}', $add->ville, $template);
                $template = str_replace('{{region}}', $add->region, $template);
                $template = str_replace('{{pays}}', $add->pays, $template);
                $template = str_replace('{{telephone}}', $add->phone ?? AuthManager::$currentLoggedInUser->phone, $template);
                $template = str_replace('{{id}}', (string) $add->abID ?? $add->id, $template);
                $template = str_replace('{{active}}', $add->principale == 1 ? 'card--active' : '', $template);
                $template = str_replace('{{tokenmodify}}', FH::csrfInput('csrftoken', $this->container->make(Token::class)->generate_token(8, 'modify-frm' . $add->abID ?? $add->id)), $template);
                $template = str_replace('{{tokenerase}}', FH::csrfInput('csrftoken', $this->container->make(Token::class)->generate_token(8, 'erase-frm' . $add->abID ?? $add->id)), $template);
                $template = str_replace('{{tokenselect}}', FH::csrfInput('csrftoken', $this->container->make(Token::class)->generate_token(8, 'select-frm' . $add->abID ?? $add->id)), $template);
                $output .= $template;
            }
        }
        return $output;
    }

    public function getHtmlData($item = [])
    {
        $template = file_get_contents(FILES . 'template' . DS . 'e_commerce' . DS . 'account' . DS . 'addessTemplate.php');
        return [$template];
    }

    public function addNewBillingAddress(array $params = [], Object $m = null)
    {
        $table = $m != null ? $m->get_tableName() : '';
        $item = [
            'other-billing-first-name' => 'firstName',
            'other-billing-last-name' => 'lastName',
            'other-billing-phone' => 'phone',
            'other-billing-email-address' => 'email',
            'other-billing-country' => 'pays',
            'billing-address-1' => 'address1',
            'billing-address-2' => 'address2',
            'billing-town-city' => 'ville',
            'billing-region' => 'region',
            'billing-zip-postal' => 'zip_code'
        ];
        $data = $this->container->make(Input::class)->transform_keys($params, $item);
        $u_related_profile = $this->container->make(UsersRelatedProfileManager::class);
        $u_related_profile->assign($data);
        $u_related_profile->userID = $m->id;
        method_exists('Form_rules', $table) ? $u_related_profile->validator($data, Form_rules::$table(false)) : '';
        if ($u_related_profile->validationPasses()) {
            if ($resp = $u_related_profile->save($data)) {
                return $resp;
            }
        }
        return ['errors' => $u_related_profile->getErrorMessages()];
    }

    /**
     * Get addresse fields
     * ==============================================================================================
     * @param array $params
     * @return void
     */
    public function get_address_fields(array $params = []) : mixed
    {
        if (!empty($params)) {
            $ad = [];
            $ad['address1'] = isset($params['address1']) ? $params['address1'] : '';
            $ad['address2'] = isset($params['address2']) ? $params['address2'] : '';
            $ad['zip_code'] = isset($params['zip_code']) ? $params['zip_code'] : '';
            $ad['region'] = isset($params['region']) ? $params['region'] : '';
            $ad['ville'] = isset($params['ville']) ? $params['ville'] : '';
            $ad['pays'] = isset($params['pays']) ? $params['pays'] : '';
            $ad['principale'] = isset($params['principale']) ? $params['principale'] : '';
            $ad['billing_addr'] = isset($params['billing_addr']) ? $params['billing_addr'] : '';
            if (!empty($ad)) {
                $this->assign($ad);
                method_exists('Form_rules', 'address_book') ? $this->validator($ad, Form_rules::address_book()) : '';
                foreach ($ad as $param) {
                    if (empty($param) && $param != '0') {
                        continue;
                    } else {
                        return $this;
                    }
                }
            }
        }
        return false;
    }

    public function partial_saveAddress(array $params = [], string $table, $id) : mixed
    {
        if ($add = $this->get_address_fields($params)) {
            $init_val = [
                'relID' => $id,
                'tbl' => $table,
            ];
            if ($add->validationPasses()) {
                return $this->partial_save((array)$add, ['where' => ['tbl' => $table, 'relID' => $id], 'return_mode' => 'class'], $this->_table, $init_val);
            } else {
                return ['errors' => $add->getErrorMessages()];
            }
        }
        return false;
    }
}