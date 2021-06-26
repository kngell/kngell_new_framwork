<?php
declare(strict_types=1);
class CheckoutController extends Controller
{
    /**
     * Main constructor
     * ====================================================================================================
     * @param string $controller
     * @param string $method
     */
    public function __construct(string $controller, string $method)
    {
        parent::__construct($controller, $method);
    }

    /**
     * Proceed to buy process
     * ====================================================================================================
     * @return void
     */
    public function proceedToBuy()
    {
        if ($this->request->exists('post')) {
            $data = $this->request->get();
            $token = self::$container->load([Token::class => []])->Token;
            if ($data['csrftoken'] && $token->validateToken($data['csrftoken'], $data['frm_name'])) {
                if (!AuthManager::currentUser()) {
                    $msg = 'login-required';
                } else {
                    $msg = 'checkout';
                }
                $this->jsonResponse(['result' => 'success', 'msg' => $msg]);
            } else {
                $this->jsonResponse(['result' => 'success', 'msg' => FH::showMessage('danger', 'invalid CSRF Token! Please try again')]);
            }
        }
    }

    public function Add()
    {
        if ($this->request->exists('post')) {
            $data = $this->request->get();
            $token = self::$container->load([Token::class => []])->Token;
            if ($data['csrftoken'] && $token->validateToken($data['csrftoken'], $data['frm_name'])) {
                $this->jsonResponse(['result' => 'success', 'msg' => $data]);
            } else {
                $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('danger', 'Bad Csrf token')]);
            }
        }
    }
}