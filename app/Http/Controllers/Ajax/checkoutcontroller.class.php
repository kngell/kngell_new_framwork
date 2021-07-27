<?php
declare(strict_types=1);
class CheckoutController extends Controller
{
    /**
     * Main constructor
     * ====================================================================================================

     */
    public function __construct()
    {
        parent::__construct();
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
            if ($data['csrftoken'] && $this->token->validateToken($data['csrftoken'], $data['frm_name'])) {
                if (!AuthManager::currentUser()) {
                    $msg = 'login-required';
                } else {
                    $msg = 'checkout';
                }
                $this->jsonResponse(['result' => 'success', 'msg' => $msg]);
            } else {
                $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('danger', 'invalid CSRF Token! Please try again')]);
            }
        }
    }

    public function get_checkoutSession()
    {
        if ($this->request->exists('post')) {
            $data = $this->request->get();
            if ($data['csrftoken'] && $this->token->validateToken($data['csrftoken'], $data['frm_name'])) {
                $this->jsonResponse(['result' => 'success', 'msg' => $this->session->get(CHECKOUT_PROCESS_NAME)]);
            } else {
                $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('danger', 'invalid CSRF Token! Please try again')]);
            }
        }
    }

    public function check_paymentMode()
    {
        if ($this->request->exists('post')) {
            $data = $this->request->get();
            if ($data['csrftoken'] && $this->token->validateToken($data['csrftoken'], $data['frm_name'])) {
                if (isset($data['pm_name']) && $data['pm_name'] == 'undefined') {
                    $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('warning', 'Choisissez un mode de paiment!')]);
                };
                $this->jsonResponse(['result' => 'success', 'msg' => 'place order']);
            }
        }
    }

    public function placeOrder()
    {
        if ($this->request->exists('post')) {
            $data = $this->request->get();
            if ($data['csrftoken'] && $this->token->validateToken($data['csrftoken'], $data['frm_name'])) {
                $userModel = $this->container->make(UsersManager::class)->assign($data);
                $pm_mode = $data['pm_name'];//$userModel->get_idFromString($data, 'pm_name') ?? 0;
                $userID = AuthManager::$currentLoggedInUser->userID;
                $userModel->id = $userID;
                method_exists('Form_rules', 'user_infos') ? $userModel->validator($data, Form_rules::user_infos()) : '';
                if ($userModel->validationPasses()) {
                    if ($data['checkout-remember-me'] == 'on') {
                        $user_resp = $userModel->save();
                    }
                    $checkoutSession = $this->session->get(CHECKOUT_PROCESS_NAME);
                    $errors = $user_resp['errors'] ?? [];

                    if (empty($errors)) {
                        $order_cart = $this->container->make(CartManager::class)->get_userCart();
                        $paymentModel = $this->container->make(PaymentGateway::class);
                        if ($pmtGateway = $paymentModel->createPaymentGateawy($data, $order_cart, (int)$pm_mode)) {
                            $pmtGateway->createCustomer();
                            $pmtGateway->createPaymentIntent();
                            $orders_infos = [
                                'pmt_infos' => $pmtGateway->getPaymentIntent(),
                                'users_data' => $user_resp ?? $data,
                                'payment_mode' => $pm_mode,
                                'user_session' => $checkoutSession
                            ];
                            if ($order = $this->container->make(OrdersManager::class)->placeOrder($orders_infos, $order_cart)) {
                                $intentResponse = $pmtGateway->confirmPaymentIntent();
                                $response = $pmtGateway->generateResponse($intentResponse);
                                if ($response['success']) {
                                    $response = $this->container->make(TransactionsManager::class)->savePayment($intentResponse, $order);
                                    if ($response->count() === 1) {
                                        $checkoutSession['transactionID'] = $intentResponse->id;
                                        $this->session->set(CHECKOUT_PROCESS_NAME, $checkoutSession);
                                        $this->jsonResponse(['result' => 'success', 'msg' => PROOT . 'payment_success']);
                                        // $this->session->delete(CHECKOUT_PROCESS_NAME);
                                        // $this->jsonResponse(['result' => 'success', 'msg' => FH::checkoutSuccessMsg($intentResponse)]);
                                    }
                                }
                            } else {
                                $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('warning', 'Impossible d\'effectuer la commande!')]);
                            }
                        }
                    } else {
                        $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('danger', 'Serveur Error! Pleae try again!')]);
                    }
                } else {
                    $errors = $this->request->transform_keys($userModel->getErrorMessages(), H::get_Newkeys($userModel, $data['frm_name']));
                    $this->jsonResponse(['result' => 'error-field', 'msg1' => $errors, 'msg2' => FH::showMessage('danger', $errors)]);
                }
            } else {
                $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('danger', 'Bad Csrf token')]);
            }
        }
    }

    public function get_creditCard()
    {
        if ($this->request->exists('post')) {
            $data = $this->request->get();
            $token = $this->container->make(Token::class);
            if ($data['csrftoken'] && $token->validateToken($data['csrftoken'], $data['frm_name'])) {
                if ($data['pmt_mode'] == '1') {
                    $default_Credit_card = $this->container->make(CreditCardManager::class)->getAllItem(['where' => ['userID' => AuthManager::$currentLoggedInUser->userID], 'return_mode' => 'class', 'limit' => 1]);
                    if ($default_Credit_card->count() === 1) {
                        $default_Credit_card = current($default_Credit_card->get_results());
                        $default_Credit_card->cc_expiry = $default_Credit_card->getDate($default_Credit_card->cc_expiry, 'm / y');
                        $this->jsonResponse(['result' => 'success', 'msg' => $default_Credit_card]);
                    } else {
                        $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('warning', 'No Credit card Found')]);
                    }
                }
            } else {
                $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('danger', 'Bad Csrf token')]);
            }
        }
    }

    public function manage_paymentModeSelectErrors()
    {
        if ($this->request->exists('post')) {
            $data = $this->request->get();
            $token = $this->container->make(Token::class);
            if ($data['csrftoken'] && $token->validateToken($data['csrftoken'], $data['frm_name'])) {
                $errors = json_decode($this->request->htmlDecode($data['error']));
                $this->jsonResponse(['msg' => FH::showMessage('warning text-center', $errors->error->message)]);
            }
        }
    }

    public function manage_changeEmail()
    {
        if ($this->request->exists('post')) {
            $data = $this->request->get();
            $token = $this->container->make(Token::class);
            if ($data['csrftoken'] && $token->validateToken($data['csrftoken'], $data['frm_name'])) {
                $model = $this->container->make(UsersManager::class)->assign($data);
                method_exists('Form_rules', 'user_infos') ? $model->validator($data, Form_rules::user_infos()) : '';
                if ($model->validationPasses()) {
                    $checkoutSession = $this->session->get(CHECKOUT_PROCESS_NAME);
                    $checkoutSession['email'] = isset($data['email']) ? $data['email'] : $checkoutSession['email'];
                    $this->session->set(CHECKOUT_PROCESS_NAME, $checkoutSession);
                    $this->jsonResponse(['result' => 'success', 'msg' => $data['email']]);
                } else {
                    $errors = $this->request->transform_keys($model->getErrorMessages(), ['email' => 'chg-email']);
                    $this->jsonResponse(['result' => 'error-field', 'msg' => $errors]);
                }
            } else {
                $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('danger', 'Bad Csrf token')]);
            }
        }
    }

    public function manage_AddAdress()
    {
        if ($this->request->exists('post')) {
            $data = $this->request->get();
            $token = $this->container->make(Token::class);
            if ($data['csrftoken'] && $token->validateToken($data['csrftoken'], $data['frm_name'])) {
                $model = $this->container->make(AddressBookManager::class)->assign($data);
                method_exists('Form_rules', 'address_book') ? $model->validator($data, Form_rules::address_book()) : '';
                if ($model->validationPasses()) {
                    $model->tbl = 'users';
                    $model->relID = AuthManager::$currentLoggedInUser->userID;
                    $resp = $model->save();
                    if ($resp['saveID']->count() > 0) {
                        $data['id'] = $resp['saveID']->get_lastID();
                        unset($data['csrftoken'], $data['url'], $data['isIE']);
                        $response = $model->get_userAddressHtml([(object)$data]);
                        $this->jsonResponse(['result' => 'success', 'msg' => $response]);
                    } else {
                        $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('danger', 'Unable to sae data§ Please contact the admin.')]);
                    }
                } else {
                    $errors = $this->request->transform_keys($model->getErrorMessages(), ['address1' => 'chg-address1', 'address2' => 'chg-address2', 'ville' => 'chg-ville', 'zip_code' => 'chg-zip_code', 'region' => 'chg-region']);
                    $this->jsonResponse(['result' => 'error-field', 'msg' => $errors]);
                }
            } else {
                $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('danger', 'Bad Csrf token')]);
            }
        }
    }

    public function manage_changeAdress()
    {
        if ($this->request->exists('post')) {
            $data = $this->request->get();
            $token = $this->container->make(Token::class);
            if ($data['csrftoken'] && $token->validateToken($data['csrftoken'], $data['frm_name'])) {
                $checkoutSession = $this->session->get(CHECKOUT_PROCESS_NAME);
                if (isset($data['id'])) {
                    $model = $this->container->make(AddressBookManager::class)->getDetails($data['id']);
                    if (!is_null($model) && $model->count() === 1) {
                        $model = current($model->get_results());
                        $address = $this->request->htmlDecode($model->address1 ?? '') . ' ' . $this->request->htmlDecode($model->address2 ?? '') . ', ' . $this->request->htmlDecode($model->zip_code ?? '') . ', ' . $this->request->htmlDecode($model->ville ?? '') . '(' . $this->request->htmlDecode($model->region ?? '') . ') - ' . $this->request->htmlDecode($model->pays ?? '');
                        if (isset($data['address_type'])) {
                            $add = $data['address_type'] == 'billing' ? 'bill_address' : 'ship_address';
                            $checkoutSession[$add]['id'] = $model->abID;
                            $checkoutSession[$add]['name'] = $address;
                            $this->session->set(CHECKOUT_PROCESS_NAME, $checkoutSession);
                            $this->jsonResponse(['result' => 'success', 'msg' => $address]);
                        } else {
                            $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('warning', 'Type d\'adress Invalide! Contactez l\'administrateur ou re-essayez.')]);
                        }
                    } else {
                        $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('warning', 'Erreur serveur! Contactez l\'administrateur ou re-essayez.')]);
                    }
                } else {
                    $checkoutSession['bill_address'] = $checkoutSession['ship_address'];
                    $this->session->set(CHECKOUT_PROCESS_NAME, $checkoutSession);
                    $this->jsonResponse(['result' => 'success', 'msg' => $checkoutSession['ship_address']['name']]);
                }
            } else {
                $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('danger', 'Bad Csrf token')]);
            }
        }
    }

    public function manage_changeShipping()
    {
        if ($this->request->exists('post')) {
            $data = $this->request->get();
            $token = $this->container->make(Token::class);
            if ($data['csrftoken'] && $token->validateToken($data['csrftoken'], $data['frm_name'])) {
                if (isset($data['shipping_class_change'])) {
                    $model = $this->container->make(ShippingClassManager::class)->getDetails($data['shipping_class_change']);
                    if ($model->count() === 1) {
                        $model = current($model->get_results());
                        $checkoutSession = $this->session->get(CHECKOUT_PROCESS_NAME);
                        $oldShippingPrice = $checkoutSession['shipping']['price'];
                        $checkoutSession['shipping']['id'] = $model->shcID;
                        $checkoutSession['shipping']['price'] = $model->price;
                        $checkoutSession['shipping']['name'] = $model->sh_name;
                        $checkoutSession['ttc'] = $checkoutSession['ttc']->plus($model->price)->minus($oldShippingPrice);
                        $this->session->set(CHECKOUT_PROCESS_NAME, $checkoutSession);
                        $this->jsonResponse(['result' => 'success', 'msg' => ['shipping' => $checkoutSession['shipping'], 'ttc' => $checkoutSession['ttc']]]);
                    }
                }
            } else {
                $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('danger', 'Bad Csrf token')]);
            }
        }
    }
}