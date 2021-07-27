<?php
declare(strict_types=1);
class RooterFactory
{
    /**
     * @var RooterInterface $router
     */
    protected RooterInterface $rooter;
    // /**
    // * @var string $dispatchedUrl
    // */
    // protected ?string $dispatchedUrl;
    /**
     *
     */

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
    public function __construct(Rooter $rooter)
    {
        // if (empty($dispatchedUrl)) {
        //     throw new BaseNoValueException('Url is not define!');
        // }
        // $this->dispatchedUrl = $request->getGet('url');
        $this->rooter = $rooter;
    }

    /**
     * Create route
     * =============================================================================
     * @param string|null $routeString
     * @return self
     */
    public function create(array $routes = []) : RooterInterface
    {
        if (!$this->rooter instanceof RooterInterface) {
            throw new BaseUnexpectedValueException($this->rooter . 'is not a valid rooter object!');
        }
        if (count($routes) > 0) {
            foreach ($routes as $method => $routes) {
                foreach ($routes as $route => $param) {
                    $this->rooter->{$method}(strtolower($route), $param);
                }
            }
        }
        return $this->rooter;
    }

    /**
     * Buil route
     * =============================================================================
     * @param string $url
     * @return void
     */
    public function buildRoutes(array $routes = [])
    {
        // if ($this->rooter->IsvalidController($this->rooter->parseUrl($this->dispatchedUrl))) {
        //     $this->rooter->dispatch();
        // };

        // if ($this->rooter->IsvalidController($this->rooter->parseUrl($this->dispatchedUrl))) {
        //     $this->rooter->dispatch();
        // };
    }

    public function getRooter()
    {
        return $this->rooter;
    }
}