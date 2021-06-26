<?php

declare(strict_types=1);

class Application
{
    protected string $appRoot;
    protected static Container $container;

    /**
     * Main constructor
     * ====================================================================================
     * @param string $appRoot
     */
    public function __construct(string $appRoot)
    {
        $this->appRoot = $appRoot;
    }

    /**
     * Run
     * ====================================================================================
     * @return self
     */
    public function run() :self
    {
        $this->constants();
        if (version_compare($phpVersion = PHP_VERSION, $coreVersion = Config::APP_MIN_VERSION, '<')) {
            die(sprintf('You are running php %s, but, the core framwork required at least PHP %s', $phpVersion, $coreVersion));
        }
        $this->environment();
        $this->errorHandler();
        // dump(YamlConfig::file('database'));
        // die();
        return $this;
    }

    /**
     * Constant
     * ====================================================================================
     * @return void
     */
    private function constants() :void
    {
        defined('DS') or define('DS', DIRECTORY_SEPARATOR);
        defined('APP_ROOT') or define('APP_ROOT', $this->appRoot);
        defined('CONFIG_PATH') or define('CONFIG_PATH', APP_ROOT . DS . 'config' . DS . 'yaml');
        defined('TEMPLATE_PATH') or define('TEMPLATE_PATH', APP_ROOT . DS . 'App' . DS);
        defined('LOG_DIR') or define('LOG_DIR', APP_ROOT . DS . 'temp' . DS . 'log');
    }

    public function setSession() :self
    {
        SystemTrait::sessionInit(true);
        return $this;
    }

    /**
     * Environnement
     * ====================================================================================
     * @return void
     */
    private function environment()
    {
        ini_set('default_charset', 'UTF-8');
    }

    /**
     * ErrorHandler
     * ====================================================================================
     * @return void
     */
    private function errorHandler() : void
    {
        error_reporting(E_ALL | E_STRICT);
        set_error_handler('ErroHandling::errorHandler');
        set_exception_handler('ErroHandling::exceptionHandler');
    }

    public function setrouteHandler(string $url = null, array $routes = []) :self
    {
        $url = $_GET['url'];
        $factory = self::$container->load([RooterFactory::class => ['dispatchedUrl' => $url, 'routes' => $routes]])->RooterFactory;
        $factory->create(Rooter::class)->buildRoutes();
        return $this;
    }
}