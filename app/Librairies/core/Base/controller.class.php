<?php

declare(strict_types=1);

class Controller
{
    protected static ContainerInterface $container;
    protected SessionInterface $session;
    protected View $view_instance;
    protected Input $request;
    protected string $controller;
    protected string $method;
    protected string $filePath;
    /**
     * Model Suffix
     *
     * @var string
     */
    protected $modelSuffix = 'Manager';

    /**
     * Main constructor
     * ==================================================================================================
     * @param string $controller
     * @param string $method
     * @param string $filePath
     */
    public function __construct(string $controller, string $method)
    {
        $this->controller = $controller;
        $this->method = $method;
    }

    /**
     * Action before and after controller
     * ==================================================================================================
     * @param array $arguments
     * @return void
     */
    public function __call(string $name, array $arguments)
    {
        $method = $name . 'Page';
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
     *  ==================================================================================================
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
     * Get Viw
     * ==================================================================================================
     * @param string $viewName
     * @param array $data
     * @return View
     */
    public function get_view(string $viewName = '', array $data = []) : View
    {
        $view = explode(DS, $viewName);
        $files = H::search_file(VIEW . strtolower($this->filePath) . strtolower($view[0]), strtolower($view[1]) . '.php');
        if ($files) {
            return !isset($this->view_instance) ? new View($viewName, $data, $this->filePath) : $this->view_instance;
        }
        return isset($this->view_instance) ? $this->view_instance : null;
    }

    /**
     * Before global conainers
     * ==================================================================================================
     * @return void
     */
    protected function before()
    {
        $this->view_instance = $this->get_view(substr($this->controller, 0, strpos($this->controller, 'Controller')) . DS . $this->method, []);
        $this->view_instance->token = self::$container->load([Token::class => []])->Token;
        if ($this->filePath == 'Client' . DS) {
            $this->view_instance->set_siteTitle("K'nGELL Ingénierie Logistique");
            $this->view_instance->products = self::$container->load([ProductsManager::class => []])->Products->set_container(self::$container)->get_Products();
            $this->view_instance->user_cart = self::$container->load([CartManager::class => []])->Cart->set_container(self::$container)->get_userCart() ?? [];
            $this->view_instance->search_box = file_get_contents(FILES . 'template' . DS . 'base' . DS . 'search_box.php');
        } elseif ($this->filePath == 'Backend' . DS) {
            $this->view_instance->set_siteTitle("K'nGELL Administration");
            $this->view_instance->set_Layout('admin');
        }
    }

    protected function after()
    {
    }

    public function get_container()
    {
        return self::$container;
    }

    /**
     * Set Container
     * ==================================================================================================
     * @param ContainerInterface $container
     * @return self
     */
    public function set_container(ContainerInterface $container) : self
    {
        if (!isset(self::$container)) {
            self::$container = $container;
        }
        return $this;
    }

    /**
     * Set request for input
     * ==================================================================================================
     * @return self
     */
    public function set_request() : self
    {
        if (!isset($this->request)) {
            $this->request = self::$container->load([Input::class => []])->Input;
        }
        return $this;
    }

    /**
     * Set Controller path
     * ==================================================================================================
     * @param string $path
     * @return self
     */
    public function set_path(string $path) : self
    {
        $this->filePath = $path;
        return $this;
    }

    /**
     * Set Session for controllers
     * ==================================================================================================
     * @return self
     */
    public function set_session() :self
    {
        if (!isset($this->session)) {
            $this->session = GlobalsManager::get('global_session');
        }
        return $this;
    }

    public function jsonResponse(array $resp)
    {
        // header('Access-Control-Allow-Origin: http://localhost');
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json; charset=UTF-8');
        header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        header('Access-Control-Expose-Headers: Content-Length, X-JSON');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, Accept, Accept-Language, X-Authorization');
        header('Access-Control-Max-Age: 86400');
        http_response_code(200);
        echo json_encode($resp);
        exit;
    }

    protected function getModelSuffix()
    {
        return $this->modelSuffix;
    }

    /**
     * Get Options Model
     * ==================================================================================================
     * @param array $data
     * @param Object $m
     * @return mixed
     */
    protected function get_optionsModel(array $data, Object $m) : mixed
    {
        if (isset($data['tbl_options']) && !empty($data['tbl_options'])) {
            $table_options = json_decode($m->htmlDecode($data['tbl_options']), true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $m = [];
                foreach ($table_options as $tbl_option) {
                    if (!empty($data['tbl_options'])) {
                        $tbl_opt = str_replace(' ', '', ucwords(str_replace('_', ' ', $tbl_option)));
                        $m[$tbl_option] = self::$container->load([$tbl_opt . 'Manager'::class => []])->$tbl_opt->set_container(self::$container);
                    }
                }
                return $m;
            } else {
                if (!empty($data['tbl_options'])) {
                    $tbl_opt = str_replace(' ', '', ucwords(str_replace('_', ' ', $data['tbl_options'])));
                    return self::$container->load([$tbl_opt . 'Manager'::class => []])->$tbl_opt->set_container(self::$container);
                }
            }
        }
        return null;
    }
}