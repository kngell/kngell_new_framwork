<?php
declare(strict_types=1);

class FormsController extends Controller
{
    public function __construct(string $controller, string $method)
    {
        parent::__construct($controller, $method);
    }

    //=======================================================================
    //Show All Items
    //=======================================================================
    public function showAll()
    {
        if ($this->request->exists('post')) {
            $data = $this->request->get();
            $token = self::$container->load([Token::class => []])->Token;
            if ($data['csrftoken'] && $token->validateToken($data['csrftoken'], $data['frm_name'])) {
                $table = str_replace(' ', '', ucwords(str_replace('_', ' ', $data['table'])));
                $model = self::$container->load([$table . 'Manager'::class => []])->$table;
                $data['method'] = 'showAll';
                $pagination = $data['pagination'];
                $tableHTML = $table . 'Table';
                $tableClass = (isset($data['user']) && $data['user'] == 'admin') ? 'TH_Admin' : 'TH';
                in_array($table, ['assoc', 'users', 'contacts']) ? $model->set_SoftDelete(true) : '';
                $output = $tableClass::$tableHTML(FH::getShowAllData($model, $this->request, $data), $token);
                if (isset($pagination) && $pagination) {
                    $output = TH::pagination($output, $model, $data);
                }
                $action = (isset($data['user']) && $data['user'] == 'guest') ? 'frontend' : 'backend';
                if ($output) {
                    $this->jsonResponse(['result' => 'success', 'msg' => $output]);
                } else {
                    $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('info text-center', 'H::get_errorMsg($this->model_instance[$table], $action, $this->_method)')]);
                }
            } else {
                $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('danger text-center', 'Bad CSRF Token')]);
            }
        }
    }

    //=======================================================================
    //Show All Items
    //=======================================================================

    public function showDetails()
    {
        if ($this->request->exists('post')) {
            $data = $this->request->get();
            $table = str_replace(' ', '', ucwords(str_replace('_', ' ', strval($data['table']))));
            $model = self::$container->load([$table . 'Manager'::class => []])->$table;
            $data['method'] = !isset($data['method']) ? 'showDetails' : $data['method'];
            $output = FH::getShowAllData($model, $this->request, $data);
            if ($output) {
                $this->jsonResponse(['result' => 'success', 'msg' => $output]);
            } else {
                $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('warning', 'erreur serveur!')]);
            }
        }
    }

    //=======================================================================
    //Adding Items
    //=======================================================================
    public function Add()
    {
        if ($this->request->exists('post')) {
            $data = $this->request->get();
            $token = self::$container->load([Token::class => []])->Token;
            if ($data['csrftoken'] && $token->validateToken($data['csrftoken'], $data['frm_name'])) {
                $table = str_replace(' ', '', ucwords(str_replace('_', ' ', $data['table'])));
                $model = self::$container->load([$table . 'Manager'::class => []])->$table->assign($data)->set_SoftDelete(true);
                method_exists('Form_rules', $table) ? $model->validator($data, Form_rules::$table()) : '';
                if ($model->validationPasses()) {
                    $action = ($table == 'users' && isset($data['action'])) ? $data['action'] : '';
                    $file = H_upload::upload_files($_FILES, $model, $this->container);
                    if ($file['success']) {
                        $model = $file['msg'];
                        if ($resp = $model->manageCheckboxes($data)->save($data)) {
                            $LastID = $resp['saveID']->get_lastID();
                            H_upload::manage_uploadImage($LastID, $table, $data);
                            (!empty($categories)) ? $model->postID = $LastID->get_lastID() : '';
                            (!empty($categories)) ? $model->saveCategories($categories, 'post_categorie') : '';
                            self::$container->load([NotificationManager::class => []])->Notification->notify(AuthManager::currentUser()->userID, $data['notification'] ?? 'Admin', 'A' . $table . ' has been added');
                            ($table == 'comments') ? $this->jsonResponse(['result' => 'success', 'msg' => $this->commentResponse($table, $model, $LastID)]) : $this->jsonResponse(['result' => 'success', 'msg' => $model->get_successMessage('Add', $action)]);
                        } else {
                            $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('warning text-center', 'Le formulaire est vide!')]);
                        }
                    }
                } else {
                    $errors = $this->request->transform_keys($model->getErrorMessages(), H::get_Newkeys($model, $data['frm_name']));
                    $this->jsonResponse(['result' => 'error-field', 'msg' => $errors]);
                }
            } else {
                $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('warning text-center', 'Bad CSRF Token!')]);
            }
        }
    }

    //Add comment response
    private function commentResponse($table, $model, $LastID)
    {
        $tableHTML = $table . 'Table';
        $model->_set_tableName($table);
        $data = $model->getAllbyId($LastID)->get_results();
        $data[0]->firstName = AuthManager::currentUser()->firstName;
        $data[0]->lastName = AuthManager::currentUser()->lastName;
        $data[0]->profileImage = AuthManager::currentUser()->profileImage;
        $output = TH::$tableHTML($data);

        return $output;
    }

    //store URL
    public function storeFiletUrl()
    {
        if ($this->request->exists('post')) {
            $data = $this->request->get();
            $table = str_replace(' ', '', ucwords(str_replace('_', ' ', $data['table'])));
            $model = self::$container->load([$table . 'Manager'::class => []])->$table->assign($data);
            $file = H_upload::upload_files($_FILES, $model);
            if ($file['success']) {
                $model->save();
                $this->jsonResponse(['result' => 'success', 'msg' => $model->fileUrl]);
            }
        }
    }

    //delete url
    public function deletepostUrl()
    {
        if ($this->request->exists('post')) {
            $file = basename($this->request->get('src'));
            file_exists(UPLOAD_ROOT . 'postsImg' . DS . $file) ? unlink(UPLOAD_ROOT . 'postsImg' . DS . $file) : '';
        }
    }

    /**
     * Edit User
     *=======================================================================
     * @return mixed
     */
    public function edit() : mixed
    {
        if ($this->request->exists('post')) {
            $data = $this->request->get();
            $token = self::$container->load([Token::class => []])->Token;
            if ($data['csrftoken'] && $token->validateToken($data['csrftoken'], $data['frm_name'])) {
                $table = str_replace(' ', '', ucwords(str_replace('_', ' ', $data['table'])));
                $model = self::$container->load([$table . 'Manager'::class => []])->$table;
                $model_option = $this->get_optionsModel($data, $model);
                if ($item = $model->getDetails((int)$data[$model->get_colID()])) {
                    if ($item->count() === 1) {
                        $item = current($item->get_results());
                        $model = null;
                        $this->jsonResponse(['result' => 'success', 'msg' => ['items' => $item, 'selectedOptions' => $this->get_options($item, $model_option, $data)]]);
                    }
                } else {
                    $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('danger', 'Server encountered errors!')]);
                }
            } else {
                $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('danger', 'Bad CSRF Token!')]);
            }
        }
    }

    // Manage Edit get selected options
    private function get_options($item = null, $model_options)
    {
        $options = [];
        if (isset($model_options)) {
            if (is_array($model_options)) {
                foreach ($model_options as $m) {
                    if (in_array($item->get_tableName(), ['products'])) {
                        $options[$item->get_fieldName($m->get_tableName())] = $m->get_Options($item->get_selectedOptions($m), $m);
                    } else {
                        $m->colOptions = $m->get_fieldName($item->get_tableName());
                        $options[$m->colOptions] = $m->get_Options($item->get_selectedOptions($m), $m);
                    }
                }
            } else {
                $options[$item->get_fieldName($model_options->get_tableName())] = $model_options->get_Options($item->get_selectedOptions($item), $model_options);
            }
        }
        $model_options = null;
        return $options;
    }

    //=======================================================================
    //Update data
    //=======================================================================

    public function update()
    {
        if ($this->request->exists('post')) {
            $data = $this->request->get();
            $token = self::$container->load([Token::class => []])->Token;
            if ($data['csrftoken'] && $token->validateToken($data['csrftoken'], $data['frm_name'])) {
                $table = str_replace(' ', '', ucwords(str_replace('_', ' ', $data['table'])));
                $model = self::$container->load([$table . 'Manager'::class => []])->$table->set_SoftDelete(true);
                $categories = ($table === 'posts' && array_key_exists('categorie', $data)) ? array_values($data['categorie']) : '';
                $colID = $model->get_colID();
                $model->getDetails($data[$colID]);
                if ($model->count() === 1) {
                    $model = current($model->get_results());
                    AuthManager::check_UserSession();
                    $model->populate($data)->setselect2Data($data);
                    $model->id = $data[$colID];
                    method_exists('Form_rules', $table) ? $model->validator($data, Form_rules::$table()) : '';
                    if ($model->validationPasses()) {
                        $file = H_upload::upload_files($_FILES, $model, $this->container);
                        if ($file['success']) {
                            $model = $file['msg'];
                            $action = ($table == 'users' && isset($data['action'])) ? $data['action'] : '';
                            if ($model->manageCheckboxes($data)->save($data)) {
                                H_upload::manage_uploadImage($model->$colID, $table, $data);
                                (!empty($categories)) ? $model->saveCategories($categories, 'post_categorie') : '';
                                self::$container->load([NotificationManager::class => []])->Notification->notify(AuthManager::currentUser()->userID, $data['notification'] ?? 'Admin', 'A' . $table . ' has been updated');
                                $this->jsonResponse(['result' => 'success', 'msg' => $model->get_successMessage('update', $data)]);
                            } else {
                                $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('danger', 'Server encountered errors!')]);
                            }
                        } else {
                            $this->jsonResponse(['result' => 'error-file', 'msg' => $file['msg']]);
                        }
                    } else {
                        $this->jsonResponse(['result' => 'error-field', 'msg' => $model->getErrorMessages()]);
                    }
                } else {
                    $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('warning', 'User not found!')]);
                }
            } else {
                $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('danger', 'Bad Csrf token')]);
            }
        }
    }

    //=======================================================================
    //Delete data
    //=======================================================================
    //check for delete
    public function checkdelete()
    {
        if ($this->request->exists('post')) {
            $data = $this->request->get();
            $token = self::$container->load([Token::class => []])->Token;
            if ($data['csrftoken'] && $token->validateToken($data['csrftoken'], $data['frm_name'])) {
                $table = str_replace(' ', '', ucwords(str_replace('_', ' ', $data['table'])));
                $model = self::$container->load([$table . 'Manager'::class => []])->$table;
                if ($output = $model->check_forEmptyParent($data[$model->get_colID()])) {
                    $model = null;
                    $this->jsonResponse(['result' => 'success', 'msg' => FH::showMessage('light', $output)]);
                } else {
                    $this->jsonResponse(['result' => 'error', 'msg' => '']);
                };
            } else {
                $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('warning', 'Bad CSRF token!')]);
            }
        }
    }

    //Delete

    public function delete()
    {
        if ($this->request->exists('post')) {
            $data = $this->request->get();
            $token = self::$container->load([Token::class => []])->Token;
            if ($data['csrftoken'] && $token->validateToken($data['csrftoken'], $data['frm_name'])) {
                $table = str_replace(' ', '', ucwords(str_replace('_', ' ', $data['table'])));
                $model = self::$container->load([$table . 'Manager'::class => []])->$table;
                in_array($table, ['contacts', 'assoc', 'users']) ? $model->set_SoftDelete(true) : '';
                if ($model->delete($data[$model->get_colID()], $data)) {
                    $SuccessMsg = $model->get_successMessage('delete', $data);
                    self::$container->load([NotificationManager::class => []])->Notification->notify(AuthManager::currentUser()->userID, $data['notification'] ?? 'Admin', $SuccessMsg);
                    $model = null;
                    $this->jsonResponse(['result' => 'success', 'msg' => $SuccessMsg]);
                } else {
                    $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('warning', 'Something goes wrong. Please try later!')]);
                }
            } else {
                $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('warning', 'Bad CSRF token!')]);
            }
        }
    }

    public function fillMultiselect()
    {
        if ($this->request->exists('post')) {
            $table = $this->request->get('table');
            $this->get_model(str_replace(' ', '', ucwords(str_replace('_', ' ', $table))) . 'Manager', $table);
            $options = $this->model_instance[$table]->getAll_inputSelectOptions();
            if ($options != '') {
                $this->jsonResponse(['result' => 'success', 'msg' => $options]);
            }
            // else {
            //     $action = ($table == 'users' && isset($_REQUEST['action'])) ? $this->request->getAll('action') : '';
            //     $errMsg = H::get_errorMsg($this->model_instance[$table], $action, $this->_method);
            //     $this->jsonResponse(['error' => 'success', 'msg' => FH::showMessage('warning text-center', $errMsg)]);
            // }
        } else {
            $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('warning text-center', 'Erreur serveur. Veuillez contacter l\'administrateur.')]);
        }
    }

    public function addcategorie()
    {
        if ($this->request->exists('post')) {
            ($this->get_model('CategoriesManager'))->assign($this->request->get());
            if ($this->model_instance->save()) {
                $this->model_instance->notify(AuthManager::currentUser()->userID, 'admin', 'A categorie has been added');
                $this->jsonResponse(['success']);
            } else {
                $this->jsonResponse(['Un problème ' . "'" . 'est posé lors de la mise à jour des catégories']);
            }
        }
    }
}