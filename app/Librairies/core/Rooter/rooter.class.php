<?php

declare(strict_types=1);
class Rooter implements RooterInterface
{
    /**
     * return an array of route from a routing table
     * @var array
     */
    protected array $routes = [];
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
    protected static ContainerInterface $container;

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
            $controller_Name = isset($url[0]) ? ucfirst(strtolower($url[0])) : $this->controller;
            $this->method = isset($url[1]) ? $url[1] : $this->method;
            unset($url[0], $url[1]);
            $this->params = count($url) > 0 ? array_values($url) : [];
            return $controller_Name;
        }
        return $this->controller;
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
            $controller = $controller . $this->controllerSuffix;
            $this->filePath = AdminClientRedirectMiddleware::redirecTo($controller);
            if ($this->filePath != '' && file_exists(CONTROLLER . $this->filePath . strtolower($controller) . '.class.php')) {
                $this->controller = $controller;
                return true;
            }
        }
        return false;
    }

    /**
     * dispatch Route
     * =====================================================================================
     * @inheritDoc
     */
    public function dispatch():void
    {
        GrantAccess::$container = self::$container;
        if (!GrantAccess::hasAccess($this->controller, $this->method)) {
            $this->controller = ACCESS_RESTRICTED . 'Controller';
            $this->method = 'index';
            $this->filePath = 'Client' . DS;
        }
        $controllerString = $this->controller;
        $method = $this->method;
        $this->set_redirect($controllerString, $method);
        if (class_exists($this->controller)) {
            $controllerObject = self::$container->load([$controllerString => [
                'controller' => $controllerString,
                'method' => $method,
            ]])->$controllerString->set_path($this->filePath)->set_request()->set_session();
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
}