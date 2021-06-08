<?php
declare(strict_types=1);
class RooterFactory
{
    /**
     * @var RooterInterface $router
     */
    protected RooterInterface $router;
    /**
    * @var string $dispatchedUrl
    */
    protected string $dispatchedUrl;
    /**
     * @var array $routes
     */
    protected array $routes;

    /**
     * Main constrctor
     * =============================================================================
     * @param string $dispatchedUrl
     * @param array $routes
     */
    public function __construct(string $dispatchedUrl = null, array $routes = [])
    {
        if (empty($routes)) {
            throw new BaseNoValueException('There are on or more empty arguments! Please ensure your <code>routes.yaml</code> is define!');
        }
        $this->dispatchedUrl = $dispatchedUrl;
        $this->routes = $routes;
    }

    /**
     * Create route
     * =============================================================================
     * @param string $routeString
     * @return self
     */
    public function create(string $routeString) :self
    {
        $this->router = new $routeString();
        if (!$this->router instanceof RooterInterface) {
            throw new BaseUnexpectedValueException($routeString . 'is not a valid router object!');
        }
        return $this;
    }

    /**
     * Buil route
     * =============================================================================
     * @param string $url
     * @return void
     */
    public function buildRoutes()
    {
        // $router = new Rooter();
        // $routes = YamlConfig::file('routes');
        if (is_array($this->routes) && !empty($this->routes)) {
            $arg = [];
            foreach ($this->routes as $key => $route) {
                if (isset($route['namespace']) && $route['namespace'] != '') {
                    $arg = ['namespace' => $route['namespace']];
                } elseif (isset($route['controller']) && $route['controller'] != '') {
                    $arg = ['controller' => $route['controller'], 'method' => $route['method']];
                }
                if (isset($key)) {
                    $this->router->add($key, $arg);
                }
            }
            $this->router->dispatch($this->dispatchedUrl);
        }
    }
}