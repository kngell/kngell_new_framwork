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
    protected ?string $dispatchedUrl;
    /**
     *
     */
    protected static ContainerInterface $container;

    /**
     * @var array $routes
     */
    // protected array $routes;
    // protected string $filePath;

    /**
     * Main constrctor
     * =============================================================================
     * @param string $dispatchedUrl
     * @param array $routes
     * @param string $filePath
     */
    public function __construct(string $dispatchedUrl = null, array $routes = [])
    {
        // if (empty($dispatchedUrl)) {
        //     throw new BaseNoValueException('Url is not define!');
        // }
        $this->dispatchedUrl = $dispatchedUrl;
    }

    /**
     * Create route
     * =============================================================================
     * @param string|null $routeString
     * @return self
     */
    public function create(?string $routeString) :self
    {
        $this->router = self::$container->load([$routeString => []])->$routeString;
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
        if ($this->router->IsvalidController($this->router->parseUrl($this->dispatchedUrl))) {
            $this->router->dispatch();
        };
    }
}