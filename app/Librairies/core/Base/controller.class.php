<?php

declare(strict_types=1);

class Controller
{
    protected ContainerInterface $container;
    protected SessionInterface $session;
    protected View $view_instance;
    protected Token $token;
    protected MoneyManager $money;
    protected Request $request;
    protected Response $response;

    /**
     * @var BaseMiddleWare $middleware
     */
    protected array $middlewares = [];

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
    public function __construct()
    {
    }

    public function iniParams($controller, $method) : self
    {
        $this->controller = $controller;
        $this->method = $method;
        return $this;
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
     * Register Controller Middlewares
     * ==================================================================================================
     * @param BaseMiddleWare $middleware
     * @return void
     */
    public function registerMiddleware(BaseMiddleWare $middleware) : void
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * Get Middlewares
     * ==================================================================================================
     * @return array
     */
    public function getMiddlewares() : array
    {
        return $this->middlewares;
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
     * @return View
     */
    public function get_view() : View
    {
        if (!isset($this->view_instance)) {
            $this->filePath = !isset($this->filePath) ? $this->container->make('ControllerPath') : $this->filePath;
            return  $this->container->make(View::class)->initParams($this->filePath);
        }
        return $this->view_instance;
    }

    /**
     * Before global conainers
     * ==================================================================================================
     * @return void
     */
    protected function before()
    {
        $this->view_instance = $this->get_view();
        $this->view_instance->token = $this->token;
        $this->view_instance->settings = $this->getSettings();
        if ($this->filePath == 'Client' . DS) {
            $this->view_instance->set_siteTitle("K'nGELL Ingénierie Logistique");
            $this->view_instance->products = $this->container->make(ProductsManager::class)->get_Products($this->brand());
            $this->view_instance->user_cart = $this->container->make(CartManager::class)->get_userCart() ?? [];
            $this->view_instance->search_box = file_get_contents(FILES . 'template' . DS . 'base' . DS . 'search_box.php');
        } elseif ($this->filePath == 'Backend' . DS) {
            $this->view_instance->set_siteTitle("K'nGELL Administration");
            $this->view_instance->set_Layout('admin');
        }
    }

    public function getSettings()
    {
        $settings = $this->container->make(GeneralSettingsManager::class)->getAllItem(['return_mode' => 'class']);
        $settingResult = new stdClass();
        if ($settings->count() > 0) {
            foreach ($settings->get_results() as $setting) {
                $settingResult->{$setting->setting_key} = $setting->value ?? '';
            }
        }
        return $settingResult;
    }

    public function getSliders()
    {
        $sliders = $this->container->make(SlidersManager::class)->getAllItem(['return_mode' => 'class']);
        if ($sliders->count() > 0) {
            $std = new stdClass();
            $sliders = $sliders->get_results();
            foreach ($sliders as $slider) {
                $page = $slider->page_slider;
                $image = $slider->p_media !== null ? unserialize($slider->p_media) : ['products' . US . 'product-80x80.jpg'];
                foreach ($image as $key => $url) {
                    $image[$key] = IMG . $url;
                }
                $slider->p_media = $image;
                $std->$page = $slider;
            }
            return $std;
        }
        return false;
    }

    protected function after()
    {
    }

    public function get_container()
    {
        return $this->container;
    }

    public function brand() : int
    {
        switch ($this->controller) {
            case 'ClothingController':
                return 3;
                break;

            default:
                return 2;
                break;
        }
    }

    /**
     * Set Container
     * ==================================================================================================
     * @param ContainerInterface $container
     * @return self
     */
    public function set_container() : self
    {
        if (!isset($this->container)) {
            $this->container = Container::getInstance();
        }
        return $this;
    }

    /**
     * Set request for input
     * ==================================================================================================
     * @return self
     */
    public function set_request($request) : self
    {
        if (!isset($this->request)) {
            $this->request = $request;
        }
        return $this;
    }

    /**
     * Set response for http
     * ==================================================================================================
     * @return self
     */
    public function set_response($response) : self
    {
        if (!isset($this->reponse)) {
            $this->response = $response;
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
        if (!isset($this->filePath)) {
            $this->filePath = $path;
        }
        return $this;
    }

    public function set_token() : self
    {
        if (!isset($this->token)) {
            $this->token = $this->container->make(Token::class);
        }
        return $this;
    }

    public function set_money() : self
    {
        if (!isset($this->money)) {
            $this->money = $this->container->make(MoneyManager::class);
        }
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

    protected function open_userCheckoutSession()
    {
        $user_data = $this->view_instance->user_data;
        $shipping = current(array_filter($this->view_instance->shipping_class->get_results(), function ($shipping) {
            return $shipping->default_shipping_class == '1';
        }));
        $userCheckoutSession = [
            'cart_items' => array_column($this->view_instance->user_cart[0], 'cart_id'),
            'email' => $user_data->email,
            'ship_address' => [
                'id' => $user_data->abID,
                'name' => $this->request->htmlDecode($user_data->address1 ?? '') . ' ' . $this->request->htmlDecode($user_data->address2 ?? '') . ', ' . $this->request->htmlDecode($user_data->zip_code ?? '') . ', ' . $this->request->htmlDecode($user_data->ville ?? '') . ' (' . $this->request->htmlDecode($user_data->region ?? '') . ') - ' . $this->request->htmlDecode($user_data->pays ?? '')
            ],
            'bill_address' => [
                'id' => $user_data->abID,
                'name' => $this->request->htmlDecode($user_data->address1 ?? '') . ' ' . $this->request->htmlDecode($user_data->address2 ?? '') . ', ' . $this->request->htmlDecode($user_data->zip_code ?? '') . ', ' . $this->request->htmlDecode($user_data->ville ?? '') . ' (' . $this->request->htmlDecode($user_data->region ?? '') . ') - ' . $this->request->htmlDecode($user_data->pays ?? '')
            ],
            'shipping' => [
                'id' => $shipping->shcID,
                'price' => $shipping->price,
                'name' => $shipping->sh_name
            ],
            'ttc' => $this->view_instance->user_cart[2][1]
        ];
        $this->session->set(CHECKOUT_PROCESS_NAME, $userCheckoutSession);
    }

    public function jsonResponse(array $resp)
    {
        $this->response->setHeader();
        // header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        // header('Access-Control-Expose-Headers: Content-Length, X-JSON');
        // header('Access-Control-Allow-Headers: Content-Type, Authorization, Accept, Accept-Language, X-Authorization');
        // header('Access-Control-Max-Age: 86400');
        // http_response_code(200);
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
                        $m[$tbl_option] = $this->container->make($tbl_opt . 'Manager'::class);
                    }
                }
                return $m;
            } else {
                if (!empty($data['tbl_options'])) {
                    $tbl_opt = str_replace(' ', '', ucwords(str_replace('_', ' ', $data['tbl_options'])));
                    return $this->container->make($tbl_opt . 'Manager'::class);
                }
            }
        }
        return null;
    }

    public function get_controller()
    {
        return $this->controller;
    }

    public function get_method()
    {
        return $this->method;
    }
}