<?php

declare(strict_types=1);
class Rooter implements RooterInterface
{
    /** @var Request $request */
    protected Request $request;

    /** @var Response $response */
    protected Response $response;

    /**
     * return an array of route from a routing table
     * @var array $routes
     */
    protected array $routes = [];
    /**
     * return an array of route from a routing table
     * @var array $routes
     */
    protected string $route = '/';
    /**
     * return an array of route parameters
     * @var array
     */
    protected array $params = [];
    /**
     * add a suffix on the controller name
     * @var array
     */
    protected string $controllerSuffix = 'Controller';
    /**
     * Default Controller
     */
    protected string $controller = DEFAULT_CONTROLLER;
    /**
     * Default Method
     */
    protected string $method = DEFAULT_METHOD;
    /**
     * File path client/admin to redirect To
     */
    protected string $filePath;
    /**
     * Container Class
     *
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    /**
     * Main constructor
     * ====================================================================================================
     * @param Request $request
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get(string $path, mixed $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post(string $path, mixed $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    /**
     * Parse URL
     * ====================================================================================================
     * @return array
     */
    public function parseUrl(string $urlroute = null) : string
    {
        $url = [];
        if (isset($urlroute) && !empty($urlroute)) {
            $url = explode('/', filter_var(rtrim($urlroute, '/'), FILTER_SANITIZE_URL));
            $route = isset($url[0]) ? strtolower($url[0]) : $this->route;
            unset($url[0]);
            $this->params = count($url) > 0 ? array_values($url) : [];
            return $route;
        }
        return $this->route;
    }

    public function resolve()
    {
        $path = strtolower($this->parseUrl($this->request->getPath()));
        $method = $this->request->getHttpmethod();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback == false) {
            throw new NotFoundException();
        }
        if (is_string($callback)) {
            return $this->renderView($callback);
        }
        if (is_array($callback)) {
            /** @var Controller $controllerObject */
            $controllerString = $this->controller = ucfirst($callback['controller']) . $this->controllerSuffix;
            $controllerMethod = $this->method = $callback['method'];
            $this->filePath = $this->getAccess();
            $this->IsvalidController($controllerString);
            if (class_exists($controllerString)) {
                $controllerObject = $this->container->make($controllerString)
                ->iniParams($controllerString, $controllerMethod)
                    ->set_request($this->request)->set_response($this->response)->set_session()
                        ->set_path($this->filePath)
                            ->set_token()
                                ->set_money();
                $this->container->controller = $controllerObject;
                $this->container->method = $controllerMethod;
                foreach ($controllerObject->getMiddlewares() as $middleware) {
                    $middleware->execute();
                }
                if (\is_callable([$controllerObject, $controllerMethod])) {
                    return $controllerObject->$controllerMethod($this->params);
                } else {
                    throw new BaseBadMethodCallException('Invalid method');
                }
            } else {
                throw new BaseBadFunctionCallException('Controller class does not exist');
            }
        }
    }

    public function getAccess()
    {
        if (!GrantAccess::hasAccess($this->controller, $this->method)) {
            throw new ForbidenException();
        } else {
            $controlerFile = YamlConfig::file('controller');
            switch ($this->controller) {
                case in_array($this->controller, $controlerFile['backend']):
                    return 'Backend' . DS;
                break;
                case in_array($this->controller, $controlerFile['ajax']):
                    return 'Ajax' . DS;
                break;
                case in_array($this->controller, $controlerFile['auth']):
                    return 'Auth' . DS;
                break;
                case in_array($this->controller, $controlerFile['asset']):
                    return 'Asset' . DS;
                break;
                default:
                    return 'Client' . DS;
                break;
            }
        }
    }

    public function renderView($view, array $params = [])
    {
        $this->view->render($view, $params);
        // $layout = $this->layout();
        // $content = $this->renderViewContent($view, $params);
        // return str_replace('{{Content}}', $content, $layout);
    }

    /**
     * Validate Controler
     * ====================================================================================================
     * @param string $controller
     * @return boolean
     */
    public function IsvalidController(string $controller): bool
    {
        if (isset($controller) && !empty($controller)) {
            if ($this->filePath != '' && file_exists(CONTROLLER . $this->filePath . strtolower($controller) . '.class.php')) {
                $this->controller = $controller;
                return true;
            } else {
                throw new NotFoundException();
            }
        } else {
            throw new NotFoundException();
        }
    }

    public function dispatch():void
    {
        // GrantAccess::$container = $this->container;
        if (!GrantAccess::hasAccess($this->controller, $this->method)) {
            $this->controller = ACCESS_RESTRICTED . 'Controller';
            $this->method = 'index';
            $this->filePath = 'Client' . DS;
        }
        $controllerString = $this->controller;
        $method = $this->method;
        $this->set_redirect($controllerString, $method);
        if (class_exists($this->controller)) {
            $controllerObject = $this->container->singleton($controllerString, function () use ($controllerString, $method) {
                return new $controllerString($controllerString, $method);
            })->make($controllerString)->set_request()->set_session()->set_path($this->filePath)->set_token()->set_money();
            if (\is_callable([$controllerObject, $method])) {
                $controllerObject->$method($this->params);
            } else {
                throw new BaseBadMethodCallException('Invalid method');
            }
        } else {
            throw new BaseBadFunctionCallException('Controller class does not exist');
        }
    }

    /**
     * Redirect
     * =====================================================================================
     * @param string $location
     * @return void
     */
    public static function redirect($location = '')
    {
        if (!headers_sent()) {
            header('location:' . PROOT . $location);
            exit();
        } else {
            echo '<script type="text/javascript">';
            echo 'window.location.href="' . PROOT . $location . '";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url=' . $location . '" />';
            echo '</noscript>';
            exit();
        }
    }

    public function set_redirect($controller, $method)
    {
        $session = GlobalsManager::get('global_session');
        $redirect_file = file_get_contents(APP . 'redirect.json');
        $redirect = json_decode($redirect_file, true);
        if (!$session->exists(REDIRECT)) {
            foreach ($redirect as $ctrl => $mth) {
                if ($ctrl == $controller) {
                    if (in_array($method, $redirect[$controller]) || in_array('*', $redirect[$controller])) {
                        $session->set(REDIRECT, 'redirect');
                    }
                }
            }
        }
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function getResponse()
    {
        return $this->response;
    }
}