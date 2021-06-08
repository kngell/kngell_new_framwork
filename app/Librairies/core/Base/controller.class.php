<?php

declare(strict_types=1);

class Controller
{
    protected array $routeParams;
    private $twig;

    public function __construct(array $routeParams)
    {
        $this->routeParams = $routeParams;
        $this->twig = new View();
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
        if ($this->twig === null) {
            throw new BaseLogicException('You cannot use the renodm method is the view is not available');
        }
        return $this->twig->twigRender($viewName, $context);
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

    protected function before()
    {
    }

    protected function after()
    {
    }
}