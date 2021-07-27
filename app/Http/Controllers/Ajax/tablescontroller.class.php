<?php
class TablesController extends Controller
{
    public function __construct(string $controller, string $method)
    {
        parent::__construct($controller, $method);
    }

    //=======================================================================
    //Update table
    //=======================================================================

    public function update()
    {
        if ($this->request->exists('post')) {
            $data = $this->request->get();
            if ($data['csrftoken'] && $this->token->validateToken($data['csrftoken'], $data['frm_name'])) {
                $table = str_replace(' ', '', ucwords(str_replace('_', ' ', $data['table'])));
                $model = $this->container->make($table . 'Manager'::class)->set_SoftDelete(true);
                $method = $data['method'];
                if ($output = $model->$method($data)) {
                    $this->jsonResponse(['result' => 'success', 'msg' => $output]);
                } else {
                    $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('warning', 'something goes wrong')]);
                }
            } else {
                $this->jsonResponse(['result' => 'error', 'msg' => FH::showMessage('danger', 'Bad Csrf token')]);
            }
        }
    }
}