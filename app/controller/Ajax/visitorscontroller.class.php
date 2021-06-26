<?php

class VisitorsController extends Controller
{
    //=======================================================================
    //Construct
    //=======================================================================
    public function __construct(string $controller, string $method)
    {
        parent::__construct($controller, $method);
    }

    //=======================================================================
    //Tract visitors
    //=======================================================================

    //visitor visit the page => save hits
    public function track()
    {
        if ($this->request->exists('post')) {
            $data = $this->request->get();
            $table = str_replace(' ', '', ucwords(str_replace('_', ' ', $data['table'])));
            $model = self::$container->load([$table . 'Manager'::class => []])->$table;
            if ($output = $model->manageVisitors($data)) {
                $this->jsonResponse(['result' => 'success', 'msg' => $output['saveID']->get_results()]);
            }
        }
    }

    public function saveipdata()
    {
        if ($this->request->exists('post')) {
            $data = $this->request->transform_keys($this->request->get(), H_visitors::new_IpAPI_keys());
            $this->model_instance->assign($data);
            if (isset($data['ipAddress']) && !$this->model_instance->getByIp($data['ipAddress'])) {
                $this->model_instance->save();
            }
        }
    }
}