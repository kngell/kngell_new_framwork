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
    protected string $controllerSiffix = 'Controller';

    //=======================================================================
    //Add route to the rooting table
    //=======================================================================

    /**
     * @inheritDoc
     */
    public function add(string $route = '', array $params = []):void
    {
        $this->routes[$route] = $params;
    }

    //=======================================================================
    //dispatch route and create
    //=======================================================================

    /**
     * @inheritDoc
     */
    public function dispatch(string $url = ''):void
    {
        if ($this->match($url)) {
            $controllerString = $this->params['Controller'];
            $controllerString = $this->transformUpperCamelCase($controllerString);
            $controllerString = $this->getNamespace($controllerString);
            if (class_exists($controllerString)) {
                $controllerObject = new $controllerString;
                $method = $this->params['method'];
                $method = $this->transformCamelCade($method);

                if (\is_callable([$controllerObject, $method])) {
                    $controllerObject->$method;
                } else {
                    throw new Exception();
                }
            } else {
                throw new Exception();
            }
        } else {
            throw new Exception();
        }
    }

    public function transformUpperCamelCase(string $string) : string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    public function transformCamelCade(string $string) : string
    {
        return \lcfirst($this->transformUpperCamelCase($string));
    }

    /**
     *match the route to the routes in routing table and
     * setting the params property if the route if found
     * @param string $url
     * @return bool
     */
    private function match(string $url):bool
    {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $param) {
                    if (is_string($key)) {
                        $params[$key] = $param;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    /**
     * Get the namespace for the controller, define within route parameters
     * only if it was added
     * @param string $str
     * @return string
     */
    public function getNamespace(string $str) : string
    {
        $namespace = "App\Controller\\";
        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }
        return $namespace;
    }
}
