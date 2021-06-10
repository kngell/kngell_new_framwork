<?php

declare(strict_types=1);

class Controller
{
    protected $model_instance;
    protected $view_instance;
    protected $request;
    protected $controller;
    protected $method;

    public function __construct($controller, $method)
    {
        $this->controller = $controller;
        $this->method = $method;
    }

    /**
     * Action before and after controller
     * =====================================================================
     * @param string $name
     * @param array $arguments
     * @return void
     */
    public function __call(string $name, array $arguments)
    {
        $method = $name . 'Method';
        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $arguments);
                $this->after();
            }
        } else {
            throw new BaseBadMethodCallException('Method ' . $name . ' does not exist in ' . get_class($this));
        }
    }

    /**
     * Render View client side
     * =================================================================================
     * @param string $viewName
     * @param array $context
     * @return void
     */
    public function render(string $viewName, array $context = [])
    {
        if ($this->view_instance === null) {
            throw new BaseLogicException('You cannot use this !');
        }
        if (!empty($context)) {
            $this->view_instance->set_viewData($context);
        }
        return $this->view_instance->render($viewName, $context);
    }

    /**
     * Get View
     *
     * @param string $viewName
     * @param array $data
     * @return void
     */
    public function get_view(string $viewName = '', $data = [])
    {
        $view = explode(DS, $viewName);
        $files = H::search_file(VIEW . strtolower($view[0]) . DS . strtolower($view[1]), strtolower($view[2]) . '.php');
        if ($files) {
            return !isset($this->view_instance) ? new View($viewName, $data) : $this->view_instance;
        }
        return isset($this->view_instance) ? $this->view_instance : null;
    }

    protected function before()
    {
        $this->view_instance = $this->get_view('client' . DS . substr($this->controller, 0, strpos($this->controller, 'Controller')) . DS . $this->method);
        $this->request = new Sanitizer();
    }

    protected function after()
    {
    }
}