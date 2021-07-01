<?php
declare(strict_types=1);
class AuthManager extends Model
{
    protected $_colID = 'userID';
    protected $_table = 'users';
    private $_sessionName;
    private $_cookieName;
    public static $currentLoggedInUser = null;
    private $_isLoggedIn = false;
    private $_confirm;
    protected $_count;
    protected SessionInterface $session;

    //=======================================================================
    //construct
    //=======================================================================

    public function __construct($user = '')
    {
        parent::__construct($this->_table, $this->_colID);
        $this->session = GlobalsManager::get('global_session');
        $this->_sessionName = CURRENT_USER_SESSION_NAME;
        $this->_cookieName = REMEMBER_ME_COOKIE_NAME;
        if ($user) {
            $u = is_int($user) ? $this->getDetails($user) : $this->getDetails($user, 'email');
            if ($u->count() > 0) {
                foreach (current($u->get_results()) as $key => $val) {
                    $this->$key = $val;
                }
            }
        }
    }

    //=====================================GUETTERS=============================================
    //=======================================================================
    //Get User email send request
    //=======================================================================

    public function getUserRequests($email = '', $type = 0, $tt = 0)
    {
        $day_ago = $tt ? $tt : time() - 60 * 60 * 24;
        $tables = ['table_join' => ['users' => ['userID', 'firstName', 'lastName', 'verified'], 'users_requests' => 'COUNT|urID']];
        $data = [
            'join' => 'LEFT JOIN',
            'rel' => [['userID', 'userID'], 'params' => ['type|=' . $type . '|users_requests', 'timestamp| >=' . $day_ago . '|users_requests']],
            'where' => ['email' => ['value' => $email, 'tbl' => 'users']],
            'group_by' => ['userID' => ['tbl' => 'users']],
            'return_mode' => 'class'
        ];
        $user = $this->getAllItem($data, $tables);
        if ($user->count() > 0) {
            $u = current($user->get_results());
            $u->_count = $user->count();
            $u->name = $u->firstName . ' ' . $u->lastName;
            $user = null;
            return [$u, (int)$u->Number];
        }
        return false;
    }

    //=======================================================================
    //Get Users login attempts
    //=======================================================================
    public function getUserLoginattemps($email)
    {
        $tables = ['users' => ['*'], 'login_attempts' => 'COUNT|laID'];
        $data = [
            'join' => 'LEFT JOIN',
            'rel' => [['userID', 'userID'], 'params' => ['timestamp| >=' . time() - 60 * 60 . '|login_attempts']],
            'where' => ['email' => ['value' => $email, 'tbl' => 'users']],
            'group_by' => ['userID' => ['tbl' => 'users']],
            'return_mode' => 'class'
        ];
        $user = $this->getAllItem($data, $tables);
        if ($user->count() > 0) {
            $u = current($user->get_results());
            $u->_count = $user->count();
            $u->name = $u->firstName . ' ' . $u->lastName;
            $user = null;
            return [$u, (int)$u->Number];
        }
        return false;
    }

    //=======================================================================
    //Login
    //=======================================================================
    public function login($rememberMe = false)
    {
        try {
            $this->id = $this->userID;
            if ($rememberMe) {
                if (!Cookies::exists($this->_cookieName)) {
                    $rem_cookie = $this->get_unique('remember_cookie');
                    Cookies::set($this->_cookieName, $rem_cookie, COOKIE_EXPIRY);
                    $this->remember_cookie = $rem_cookie;
                    $this->save();
                } else {
                    if ($this->remember_cookie != Cookies::get($this->_cookieName)) {
                        $this->remember_cookie = Cookies::get($this->_cookieName);
                        $this->save();
                    }
                }
            }
            // check for visitor cookies
            if (!Cookies::exists(VISITOR_COOKIE_NAME)) {
                $visitor = $this->container->load([VisitorsManager::class => []])->Visitors->add_new_visitor(H_visitors::getVisitorData('91.173.88.22'));
                $this->user_cookie = $visitor->cookies;
                $this->save();
            } elseif (!$this->user_cookie) {
                $this->user_cookie = Cookies::get(VISITOR_COOKIE_NAME);
                $this->save();
            } else {
                $cookies = Cookies::get(VISITOR_COOKIE_NAME);
                if ($this->user_cookie != $cookies) {
                    $this->user_cookie = $cookies;
                    $this->save();
                }
            }
            //create a temporary user session
            self::$container->load([UserSessionsManager::class => []])->UserSessions->set_userSession($this);
            $this->session->set($this->_sessionName, $this->email);
            $this->session->set(CONTAINER_NAME, self::$container);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    //=======================================================================
    //Logout
    //=======================================================================
    public function logout()
    {
        try {
            //check visitor Cookies
            if (!Cookies::exists(VISITOR_COOKIE_NAME)) {
                $this->container->load([VisitorsManager::class => []])->Visitors->add_new_visitor();
            }
            //Delete Session
            $this->session->delete(CURRENT_USER_SESSION_NAME) ;
            $this->session->delete(CHECKOUT_PROCESS_NAME) ;
            $this->session->delete(CONTAINER_NAME) ;
            session_destroy();
            // $this->session->invalidate();
            self::$currentLoggedInUser = null;
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    //=======================================================================
    //Delete User Account
    //=======================================================================
    public function deleteUserAccount($user = null)
    {
        try {
            $this->container->load([UsersRequestsManager::class => []])->UsersRequests->delete('', ['userID' => $user->userID]);
            $this->container->load([LoginAttemptsManager::class => []])->LoginAttempts->delete('', ['userID' => $user->userID]);
            $this->container->load([UserSessionsManager::class => []])->UserSessions->delete('', ['userID' => $user->userID]);
            $this->container->load([UserExtraDataManager::class => []])->UserExtraData->delete('', ['userID' => $user->userID]);
            $this->container->load([AddressBookManager::class => []])->AddressBook->delete('', ['relID' => $user->userID]);
            $this->container->load([GroupUserManager::class => []])->GroupUser->delete('', ['userID' => $user->userID]);
            if (Cookies::exists(REMEMBER_ME_COOKIE_NAME)) {
                Cookies::delete(REMEMBER_ME_COOKIE_NAME);
            }
            $this->session->delete(CURRENT_USER_SESSION_NAME);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    // check if user is logged
    public function isLoggedIn()
    {
        return $this->_isLoggedIn;
    }

    //find Password
    public function findPassword()
    {
        $data = [
            'where' => ['userID' => $this->userID], 'return_type' => 'single', 'select' => 'password'
        ];
        return $this->findFirst($data);
    }

    //=======================================================================
    //Check current user state
    //=======================================================================
    public static function currentUser()
    {
        $session = GlobalsManager::get('global_session');
        if ($session->exists(CURRENT_USER_SESSION_NAME)) {
            $email = $session->get(CURRENT_USER_SESSION_NAME);
            if (!isset(self::$currentLoggedInUser)) {
                self::$currentLoggedInUser = new self((string) $email);
            }
        }
        return self::$currentLoggedInUser;
    }

    //=======================================================================
    //Check user session
    //=======================================================================
    public static function check_UserSession($params = [])
    {
        $session = GlobalsManager::get('global_session');
        if (isset($params['userID'])) {
            (self::$currentLoggedInUser->userID == $params['userID'] && self::$currentLoggedInUser->email != $params['email']) ? $session->set(CURRENT_USER_SESSION_NAME, $params['email']) : '';
        }
    }

    //=======================================================================
    //Delete and restore users
    //=======================================================================
    public function deleteUser($id, $complete)
    {
        !$complete ? $this->_softDelete = true : '';
        return $this->delete('UserId', $id);
    }

    //=======================================================================
    //Restore users
    //=======================================================================
    public function restoreUser($id)
    {
        $fields = ['deleted' => 0];
        return $this->update(['userID' => $id], $fields);
    }

    //=======================================================================
    //Register
    //=======================================================================
    public function register()
    {
        if (!Cookies::exists(VISITOR_COOKIE_NAME)) {
            $v_cookie = $this->get_unique('user_cookie');
            Cookies::set(VISITOR_COOKIE_NAME, $v_cookie, COOKIE_EXPIRY);
            $this->user_cookie = $v_cookie ;
        }
        $this->user_cookie = Cookies::get(VISITOR_COOKIE_NAME);
        return $this->save();
    }

    //Check for remember me cookies
    public function rememberMe_checker()
    {
        $user_data = [];
        if (Cookies::exists(VISITOR_COOKIE_NAME)) {
            $visitor = Cookies::get(VISITOR_COOKIE_NAME);
            $user_session = $this->container->load([UserSessionsManager::class => []])->UserSessions;
            if ($user_session && $user_session->remember_cookie) {
                $user_data['remember'] = true;
                $user_data['email'] = $user_session->email ?? '';
            }
        }
        return $user_data;
    }

    //login From Facebook
    public static function loginFromFacebook($userData)
    {
        $user = new self($userData['email']);
        if (!$user->getDetails($userData['email'], 'email')) {
            $user->firstName = $userData['first_name'];
            $user->lastName = $userData['last_name'];
            $user->email = $userData['email'];
            $user->fb_access_token = $userData['accessToken'];
            $user->profileImage = $userData['picture']['url'];
            $user->save();
            $subject = 'Email verification';
            $body = '<h3>Cliquez sur le lien ci-dessous pour changer pour vérifier votre email</h3>.<p><a href="' . URLROOT . 'users/emailVerified/' . $userData['email'] . '">' . URLROOT . 'users/emailVerified/' . $userData['email'] . '</a><br>KnGELL! </p><p>Vous disposez de 30 minutes pour changer votre mot de pass. Au delà, vous devrez recommencer</p>';
            H_Email::sendEmail($userData['email'], $subject, $body, $body);
            $user->login();
        } else {
            $user->login();
        }
    }

    /**
     * ACL Permissions fromdataBase
     * ==================================================================================================
     * @return void
     */
    public function acls()
    {
        return $this->container->load([UsersManager::class => []])->Users->set_container($this->container)->get_selectedOptions($this) ?? [];
    }

    //form validation
    public function validator(array $source = [], array $items = [])
    {
        FH::validate_forms($source, $items, $this);
    }

    //=======================================================================
    //Getters
    //=======================================================================

    public function displayName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function get_columnNames()
    {
        return $this->_columnNames;
    }

    public function getConfirm()
    {
        return $this->_confirm;
    }

    //=======================================================================
    //Setters
    //=======================================================================
    public function setConfirm($value)
    {
        $this->_confirm = $value;
    }

    //=======================================================================
    //Operations
    //=======================================================================

    //Before Save
    public function beforeSave($params = [])
    {
        if (property_exists($this, 'cpassword')) {
            unset($this->cpassword);
        }
        if (property_exists($this, 'terms')) {
            unset($this->terms);
        }

        if ($this->isNew() == true) {
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
            $this->salt = $this->get_unique('salt');
        }
        //Unset Auth providers ???
        unset($this->oauth_provider, $this->oauth_uid,$this->link);
        if (isset($this->Number)) {
            unset($this->Number);
        }
        if (isset($this->name)) {
            unset($this->name);
        }
        return true;
    }

    //confirm Email
    public function confirmEmail($email)
    {
        $cond = ['email' => $email];
        return ($this->update($cond, ['verified' => 1]))->count();
    }

    //find user when resetting password
    public function find_from_reset_password($email, $token)
    {
        $conditions = [
            'where' => [
                'token' => !(null),
                'token' => $token,
                'deleted' => !1,
                'email' => $email
            ],
            'return_mode' => 'class',
            'return_type' => 'single'
        ];
        $row = $this->getAllItem($conditions);
        return $row;
    }

    //Before update
    public function beforeSaveUpadate($fields = [])
    {
        return parent::beforeSaveUpadate($fields);
    }
}