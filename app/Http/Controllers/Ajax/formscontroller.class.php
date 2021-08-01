<?php
declare(strict_types=1);

class FormsController extends Controller
{
    public function __construct()
    {
    }

    //=======================================================================
    //Show All Items
    //=======================================================================
    public function showAll()
    {
        if ($this->request->exists('post')) {
            $data = $this->request->get();
            if ($data['csrftoken'] && $this->token->validateToken($data['csrftoken'], $data['frm_name'])) {
                $table = str_replace(' ', '', ucwords(str_replace('_', ' ', $data['table'])));
                $model = $this->container->make($table . 'Manager'::class);
                $data['method'] = 'showAll';
                $pagination = $data['pagination'];
                in_array($table, ['assoc', 'users', 'contacts']) ? $model->set_SoftDelete(true) : '';
                $tableClass = 'TH' . $table;
                $output = $this->container->make($tableClass)->{lcfirst($table) . 'Table'}(FH::getShowAllData($model, $data));
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
            if ($data['csrftoken'] && $this->token->validateToken($data['csrftoken'], $data['frm_name'])) {
                $table = str_replace(' ', '', ucwords(str_replace('_', ' ', strval($data['table']))));
                $model = $this->container->make($table . 'Manager'::class);
                $data['method'] = !isset($data['method']) ? 'showDetails' : $data['method'];
                $output = FH::getShowAllData($model, $data);
                if ($output) {
                    $this->jsonResponse(['result' => 'success', 'msg' => $output]);
                } else {
                    $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('warning', 'erreur serveur!')]);
                }
            } else {
                $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('danger text-center', 'Bad CSRF Token')]);
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
            if ($data['csrftoken'] && $this->token->validateToken($data['csrftoken'], $data['frm_name'])) {
                $table = str_replace(' ', '', ucwords(str_replace('_', ' ', $data['table'])));
                $model = $this->container->make($table . 'Manager'::class)->assign($data)->set_SoftDelete(true)->setselect2Data($data);
                method_exists('Form_rules', $table) ? $model->validator($data, Form_rules::$table()) : '';
                if ($model->validationPasses()) {
                    $action = ($table == 'users' && isset($data['action'])) ? $data['action'] : null;
                    $file = H_upload::upload_files($this->request->getFiles(), $model, $this->container);
                    if ($file['success']) {
                        $model = $file['msg'];
                        if ($resp = $model->manageCheckboxes($data)->save($data)) {
                            $LastID = isset($resp) ? $resp->get_lastID() : $resp->get_lastID();
                            H_upload::manage_uploadImage($LastID, $table, $data);
                            (!empty($categories)) ? $model->postID = $LastID->get_lastID() : '';
                            (!empty($categories)) ? $model->saveCategories($categories, 'post_categorie') : '';
                            $this->container->make(NotificationManager::class)->notify(AuthManager::currentUser()->userID, $data['notification'] ?? 'Admin', 'A' . $table . ' has been added');
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
            $model = $this->container->make($table . 'Manager'::class)->assign($data);
            $file = H_upload::upload_files($this->request->getFiles(), $model);
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
            if ($data['csrftoken'] && $this->token->validateToken($data['csrftoken'], $data['frm_name'])) {
                $table = str_replace(' ', '', ucwords(str_replace('_', ' ', $data['table'])));
                $model = $this->container->make($table . 'Manager'::class);
                $model_option = $this->get_optionsModel($data, $model);
                $method = isset($data['custom_method']) ? $data['custom_method'] : 'getDetails';
                if ($model->$method((int)$data[$model->get_colID()])) {
                    if ($model->count() === 1) {
                        $model = current($model->get_results());
                        $this->jsonResponse(['result' => 'success', 'msg' => ['items' => Sanitizer::cleanOutputModel($model), 'selectedOptions' => $this->get_options($model, $model_option, $data)]]);
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
    private function get_options($model = null, $model_options)
    {
        $options = [];
        if (isset($model_options)) {
            if (is_array($model_options)) {
                foreach ($model_options as $m) {
                    if (in_array($model->get_tableName(), ['products'])) {
                        $options[$model->get_fieldName($m->get_tableName())] = $m->get_Options($model->get_selectedOptions($m), $m);
                    } else {
                        $m->colOptions = $m->get_fieldName($model->get_tableName());
                        $options[$m->colOptions] = $m->get_Options($m->get_tableName() != 'countries' ? $model->get_selectedOptions($m) : [$m->colOptions => $model->{$m->colOptions}], $m);
                    }
                }
            } else {
                $options[$model->get_fieldName($model_options->get_tableName())] = $model_options->get_Options($model->get_selectedOptions($model), $model_options);
            }
        }
        if (in_array(get_class($model), ['OrdersManager'])) {
            $options = $this->request->transform_keys($options, ['ord_userID' => 'customer']);
        }
        $model_options = null;
        $model = null;

        return $options;
    }

    //=======================================================================
    //Update data
    //=======================================================================

    public function update()
    {
        if ($this->request->exists('post')) {
            $data = $this->request->get();
            if ($data['csrftoken'] && $this->token->validateToken($data['csrftoken'], $data['frm_name'])) {
                $table = str_replace(' ', '', ucwords(str_replace('_', ' ', $data['table'])));
                $model = $this->container->make($table . 'Manager'::class)->set_SoftDelete(true);
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
                        $file = H_upload::upload_files($this->request->getFiles(), $model, $this->container);
                        if ($file['success']) {
                            $model = $file['msg'];
                            $action = ($table == 'users' && isset($data['action'])) ? $data['action'] : '';
                            if ($model->manageCheckboxes($data)->save($data)->count() === 1) {
                                H_upload::manage_uploadImage($model->$colID, $table, $data);
                                (!empty($categories)) ? $model->saveCategories($categories, 'post_categorie') : '';
                                $this->container->make(NotificationManager::class)->notify(AuthManager::currentUser()->userID, $data['notification'] ?? 'Admin', 'A' . $table . ' has been updated');
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
            if ($data['csrftoken'] && $this->token->validateToken($data['csrftoken'], $data['frm_name'])) {
                $table = str_replace(' ', '', ucwords(str_replace('_', ' ', $data['table'])));
                $model = $this->container->make($table . 'Manager'::class);
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
            if ($data['csrftoken'] && $this->token->validateToken($data['csrftoken'], $data['frm_name'])) {
                $table = str_replace(' ', '', ucwords(str_replace('_', ' ', $data['table'])));
                $model = $this->container->make($table . 'Manager'::class);
                in_array($table, ['contacts', 'assoc', 'users']) ? $model->set_SoftDelete(true) : '';
                if ($model->delete($data[$model->get_colID()], $data)) {
                    $SuccessMsg = $model->get_successMessage('delete', $data);
                    $this->container->make(NotificationManager::class)->notify(AuthManager::currentUser()->userID, $data['notification'] ?? 'Admin', $SuccessMsg);
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