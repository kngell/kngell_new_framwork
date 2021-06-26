<?php
declare(strict_types=1);
class GuestsController extends Controller
{
    public function __construct(string $controller, string $method)
    {
        parent::__construct($controller, $method);
    }

    //=======================================================================
    //Coutries
    //=======================================================================

    public function get_countries()
    {
        if ($this->request->exists('post')) {
            $data = $this->request->get();
            $token = self::$container->load([Token::class => []])->Token;
            if ($data['csrftoken'] && $token->validateToken($data['csrftoken'], $data['frm_name'])) {
                $search = strtolower($data['searchTerm']);
                $conutries_json = file_get_contents(FILES . 'json' . DS . 'data' . DS . 'countries.json');
                $countries = array_filter(array_column(json_decode($conutries_json, true), 'name'), function ($countrie) use ($search) {
                    return str_starts_with(strtolower($countrie), $search);
                });
                $results = array_map(
                    function ($i, $map_countrie) {
                        return ['id' => $i, 'text' => $map_countrie];
                    },
                    array_keys($countries),
                    $countries
                );
                $this->jsonResponse(['result' => 'success', 'msg' => $results]);
            }
        }
    }

    //=======================================================================
    //Add
    //=======================================================================
    public function Add()
    {
        if ($this->request->exists('post')) {
            $data = $this->request->get();
            $token = self::$container->load([Token::class => []])->Token;
            if ($data['csrftoken'] && $token->validateToken($data['csrftoken'], $data['frm_name'])) {
                $table = str_replace(' ', '', ucwords(str_replace('_', ' ', $data['table'])));
                $this->model_instance = self::$container->load([$table . 'Manager'::class => []])->$table;
                $file = H_upload::upload_files($_FILES, $this->model_instance, $this->container);
                if ($file['success']) {
                    $this->model_instance->assign($data);
                    method_exists('Form_rules', $table) ? $this->model_instance->validator($data, Form_rules::$table()) : '';
                    if ($this->model_instance->validationPasses()) {
                        if ($resp = $this->model_instance->save($data)) {
                            $action = ($table == 'utilisateur' && isset($_REQUEST['action'])) ? $data['action'] : '';
                            $success_msg = $this->model_instance->get_successMsg($resp, $action, 'Add');
                            $output_msg = (isset($data['wrap_msg']) && $data['wrap_msg'] == true) ? FH::showMessage('success text-center p-3', $success_msg) : $success_msg;
                            $this->jsonResponse(['result' => 'success', 'msg' => $output_msg]);
                        } else {
                            $err_msg = !in_array($table, ['cart']) ? FH::showMessage('danger', 'Server encountered errors!') : false;
                            $this->jsonResponse(['result' => 'error', 'msg' => $err_msg]);
                        }
                    } else {
                        $errors = $this->request->transform_keys($this->model_instance->getErrorMessages(), H::get_Newkeys($this->model_instance, $data['frm_name']));
                        $this->jsonResponse(['result' => 'error-field', 'msg' => $errors]);
                    }
                } else {
                    $this->jsonResponse(['result' => 'error-field', 'msg' => $file['msg']]);
                }
            }
        }
    }

    //add to cart (ecommerce), from whishlist
    public function toggleWishlistAndcCart()
    {
        if ($this->request->exists('post')) {
            $data = $this->request->get();
            $token = self::$container->load([Token::class => []])->Token;
            if ($data['csrftoken'] && $token->validateToken($data['csrftoken'], $data['frm_name'])) {
                $table = str_replace(' ', '', ucwords(str_replace('_', ' ', $data['table'])));
                $model = self::$container->load([$table . 'Manager'::class => []])->$table;
                $model->assign($data);
                $method = isset($data['method']) ? $data['method'] : '';
                if ($output = $model->manage_user_cart($method)) {
                    $this->jsonResponse(['result' => 'success', 'msg' => $output]);
                } else {
                    $this->jsonResponse(['result' => 'error', 'msg' => '']);
                }
            }
        }
    }

    private function sendMail($data)
    {
        $to = 'daniel.akono@kngell.com';
        $body = '';
        $body .= 'You have a new message from ' . $data['email'] . ' into your ' . $data['table'] . ' table' . "\r\n";
        $subject = 'New candidate has sent a cv';
        H_Email::sendmailgrid($to, $subject, $body);
        //mail($to, $subjet, $body);
    }

    //=======================================================================
    //Search bar
    //=======================================================================

    public function search()
    {
        if ($this->request->exists('post')) {
            $data = $this->request->get();
            $token = self::$container->load([Token::class => []])->Token;
            if ($data['csrftoken'] && $token->validateToken($data['csrftoken'], $data['frm_name'])) {
                $table = str_replace(' ', '', ucwords(str_replace('_', ' ', $data['table'])));
                $model = self::$container->load([$table . 'Manager'::class => []])->$table;
                if (!empty($data['search'])) {
                    $tables = (self::$container->load([SearchManager::class => []]))->Search->getAll_tables();
                    if ($output = TH::searchTable($tables, $model, $data)) {
                        $this->jsonResponse(['result' => 'success', 'msg' => $output]);
                    } else {
                        $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('info text-center', '0 resultat(s)')]);
                    }
                } else {
                    $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('info text-center', 'la barre de recherche est vide')]);
                }
            }
        }
    }

    //=======================================================================
    //Search bar results
    //=======================================================================
    public function search_results($data)
    {
        $this->view_instance->set_viewData($data);
        $this->view_instance->render('home' . DS . 'search');
    }

    //=======================================================================
    //Delete data
    //=======================================================================

    public function delete()
    {
        if ($this->request->exists('post')) {
            $data = $this->request->get();
            $token = self::$container->load([Token::class => []])->Token;
            if ($data['csrftoken'] && $token->validateToken($data['csrftoken'], $data['frm_name'])) {
                $table = str_replace(' ', '', ucwords(str_replace('_', ' ', $data['table'])));
                $this->model_instance = self::$container->load([$table . 'Manager'::class => []])->$table;
                $method = isset($data['method']) ? $data['method'] : '';
                $output = $method != '' ? $this->model_instance->$method($data) : $this->model_instance->delete($data);
                if ($output) {
                    $this->jsonResponse(['result' => 'success', 'msg' => $output]);
                }
            }
        }
    }

    //=======================================================================
    //Simple ajax call
    //=======================================================================
    public function call()
    {
        $data = $this->request->get();
        $table = str_replace(' ', '', ucwords(str_replace('_', ' ', $data['table'])));
        $model = self::$container->load([$table . 'Manager'::class => []])->$table;
        $method = isset($data['method']) ? $data['method'] : '';
        if ($output = $model->$method($data)) {
            $this->jsonResponse(['result' => 'success', 'msg' => $output]);
        }
    }
}