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

    public function checkout()
    {
        if ($this->request->exists('post')) {
            $data = $this->request->get();
            $token = self::$container->load([Token::class => []])->Token;
            if ($data['csrftoken'] && $token->validateToken($data['csrftoken'], $data['frm_name'])) {
                $userModel = self::$container->load([UsersManager::class => []])->Users->assign($data);
                $pm_mode = $userModel->get_idFromString($data, 'pm_name') ?? 0;
                if ($payment_infos = $this->save_payment($data, (int)$pm_mode)) {
                    $userID = AuthManager::$currentLoggedInUser->userID;
                    $userModel->id = $userID;
                    method_exists('Form_rules', 'user_infos') ? $userModel->validator($data, Form_rules::user_infos()) : '';
                    if ($userModel->validationPasses()) {
                        if ($user_resp = $userModel->save($data)) {
                            $shippingClass = $userModel->get_idFromString($data, 'sh_name');
                            $prefered_billing_address = $data['prefred_billing_addr'];
                            if ($prefered_billing_address == 2) {
                                $data['billing_addr'] = 'on';
                                $billing_address = self::$container->load([AddressBookManager::class => []])->AddressBook->addNewBillingAddress($data, $userModel);
                            }
                            $errors = array_merge($user_resp['errors'] ?? [], $billing_address['errors'] ?? []);
                            if (empty($errors)) {
                                $orders_infos = [
                                    'pmt_infos' => $payment_infos,
                                    'payment_mode' => $pm_mode,
                                    'users_data' => $user_resp,
                                    'shipping' => $shippingClass,
                                    'billing_addr_mode' => $prefered_billing_address,
                                    'billing_addr' => $billing_address ?? []
                                ];
                                $order = self::$container->load([OrdersManager::class => []])->Orders->placeOrder($orders_infos);
                                $this->jsonResponse(['result' => 'success', 'msg' => '']);
                            } else {
                                $errors = $this->request->transform_keys($billing_address['errors'], ['email' => 'other-billing-email-address']);
                                $this->jsonResponse(['result' => 'error-field', 'msg1' => $errors, 'msg2' => FH::showMessage('danger', $errors)]);
                            }
                        } else {
                            $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('danger', 'Server encountered errors!')]);
                        }
                    } else {
                        $errors = $this->request->transform_keys($userModel->getErrorMessages(), H::get_Newkeys($userModel, $data['frm_name']));
                        $this->jsonResponse(['result' => 'error-field', 'msg1' => $errors, 'msg2' => FH::showMessage('danger', $errors)]);
                    }
                }
            } else {
                $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('danger', 'Bad Csrf token')]);
            }
        }
    }

    private function save_payment(array $data = [], int $pm_mode = 0) : CreditCardManager
    {
        $credit_cardModel = self::$container->load([CreditCardManager::class => []])->CreditCard->getDetails($data['cc_number'], 'cc_number');
        if ($credit_cardModel->count() === 1) {
            $credit_cardModel = current($credit_cardModel->get_results())->populate($data);
            $colID = $credit_cardModel->get_colID();
            $credit_cardModel->id = $credit_cardModel->$colID;
            method_exists('Form_rules', 'credit_card') ? $credit_cardModel->validator($data, Form_rules::credit_card()) : '';
            if ($credit_cardModel->validationPasses()) {
                $credit_cardModel->cc_expiry = $credit_cardModel->get_expiryDate($credit_cardModel->cc_expiry);
                if ($resp_cc = $credit_cardModel->save($data)) {
                    return $credit_cardModel;
                } else {
                    $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('danger', 'Server encountered errors!')]);
                }
            } else {
                $this->jsonResponse(['result' => 'error-field', 'msg1' => $credit_cardModel->getErrorMessages(), 'msg2' => FH::showMessage('danger', $credit_cardModel->getErrorMessages())]);
            }
        } else {
            $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('warning', 'No Payment found! Please choose Payment.')]);
        }
    }

    public function get_creditCard()
    {
        if ($this->request->exists('post')) {
            $data = $this->request->get();
            $token = self::$container->load([Token::class => []])->Token;
            if ($data['csrftoken'] && $token->validateToken($data['csrftoken'], $data['frm_name'])) {
                if ($data['pmt_mode'] == '1') {
                    $default_Credit_card = self::$container->load([CreditCardManager::class => []])->CreditCard->getAllItem(['where' => ['userID' => AuthManager::$currentLoggedInUser->userID, 'cc_default' => 'default'], 'return_mode' => 'class']);
                    if ($default_Credit_card->count() === 1) {
                        $default_Credit_card = current($default_Credit_card->get_results());
                        $default_Credit_card->cc_expiry = $default_Credit_card->getDate($default_Credit_card->cc_expiry, 'm / y');
                        $this->jsonResponse(['result' => 'success', 'msg' => $default_Credit_card]);
                    }
                }
            } else {
                $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('danger', 'Bad Csrf token')]);
            }
        }
    }
}