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
    protected string $controller = DEFAULT_CONTROLLER;
    protected string $method = DEFAULT_METHOD;

    /**
     * Parse URL
     * ====================================================================================================
     * @return array
     */
    public function parseUrl() : string
    {
        $url = [];
        if (isset($_GET['url'])) {
            $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
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
            if (file_exists(CONTROLLER . strtolower($controller) . '.class.php')) {
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
        $storageObject = new NativeSessionStorage(YamlConfig::file('session'));
        $session = (new Session('generic_session_name', $storageObject))->get('global_session');
        $global = $GLOBALS;
        // if (!GrantAccess::hasAccess($this->controller, $this->method)) {
        //     $this->controller = ACCESS_RESTRICTED . 'Controller';
        //     $this->method = 'index';
        // }
        $controllerString = $this->controller;
        $method = $this->method;
        if (class_exists($this->controller)) {
            $controllerObject = new $controllerString($controllerString, $method);
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
}