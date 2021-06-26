<?php
declare(strict_types=1);
class UsersController extends Controller
{
    public function __construct(string $controller, string $method)
    {
        parent::__construct($controller, $method);
    }

    //=======================================================================
    //Account
    //=======================================================================
    public function accountPage($data)
    {
        $page = array_pop($data);
        $this->view_instance->set_pageTitle(ucfirst($page));
        $this->view_instance->set_siteTitle(ucfirst($page));
        $this->view_instance->set_viewData(self::$container->load([UsersManager::class => []])->Users);
        if (in_array($page, ['account', 'profile', 'payment', 'login', 'register'])) {
            if (isset(AuthManager::$currentLoggedInUser)) {
                !in_array($page, ['login', 'register']) ? $this->view_instance->render('users' . DS . 'account' . DS . $page) : '';
            } else {
                if ($page == 'register') {
                    $temp = file_get_contents(VIEW . $this->filePath . 'users' . DS . 'account' . DS . 'partials' . DS . '_register.php');
                    $temp = str_replace('{{link}}', PROOT . 'users' . DS . 'account' . DS . 'login', $temp);
                    $temp = str_replace('{{csrf}}', FH::csrfInput('csrftoken', self::$container->load([Token::class => []])->Token->generate_token(8)), $temp);
                } else {
                    $temp = file_get_contents(VIEW . $this->filePath . 'users' . DS . 'account' . DS . 'partials' . DS . '_login.php');
                    $temp = str_replace('{{link}}', PROOT . 'users' . DS . 'account' . DS . 'register', $temp);
                    $temp = str_replace('{{csrf}}', FH::csrfInput('csrftoken', self::$container->load([Token::class => []])->Token->generate_token(8)), $temp);
                }
                $this->view_instance->log_file = $temp;
                $this->view_instance->render('users' . DS . 'account' . DS . 'login');
                $temp = '';
            }
        } else {
            Rooter::redirect('restricted' . DS . 'index');
        }
    }

    //=======================================================================
    //Checkout
    //=======================================================================
    public function checkoutPage()
    {
        $this->view_instance->set_pageTitle('Checkout');
        $this->view_instance->set_siteTitle('Checkout');
        if (isset(AuthManager::$currentLoggedInUser)) {
            $this->view_instance->user_data = self::$container->load([UsersManager::class => []])->Users->get_single_user(AuthManager::$currentLoggedInUser->userID);
            $this->view_instance->shipping_class = self::$container->load([ShippingClassManager::class => []])->ShippingClass->getAllItem(['return_mode' => 'class']);
            $this->view_instance->render('users' . DS . 'checkout' . DS . 'checkout');
        } else {
            Rooter::redirect('users' . DS . 'account' . DS . 'login');
        }
    }

    //=======================================================================
    //Profile
    //=======================================================================
    public function profile()
    {
        // dd(($this->get_model('UsersManager')['users'])->get_Tables_Column('commandes'));
        $this->view_instance->set_pageTitle('Profile');
        $this->view_instance->set_siteTitle('Profile');
        $this->view_instance->render('users' . DS . 'account' . DS . 'profile');
    }

    //=======================================================================
    //Email verified results
    //=======================================================================
    public function emailverified($data)
    {
        $msg = '';
        foreach ($data as $value) {
            $msg .= $value;
        }
        $this->view_instance->msg = $msg;
        $this->view_instance->set_pageTitle('Email Verification');
        $this->view_instance->render('users' . DS . 'emailverified');
    }

    //=======================================================================
    //Reset password
    //=======================================================================
    public function resetpassword($data)
    {
        $this->view_instance->set_pageTitle('Reset Password');
        $this->view_instance->render('users' . DS . 'account' . DS . 'resetpassword');
    }

    //Payment
    public function payment()
    {
        $this->view_instance->set_pageTitle('Payment Paypal');
        $this->view_instance->render('users' . DS . 'account' . DS . 'payment');
    }
}