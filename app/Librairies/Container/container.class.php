<?php
declare(strict_types=1);

/**
 * Describes the interface of a container that exposes methods to read its entries.
 */
class Container implements ContainerInterface
{
    /** @var array */
    protected array $instance = [];
    /** @var array */
    protected array $services = [];
    /** @var array */
    protected array $excludes = [];
    /** @var Object */
    protected ?Object $service = null;
    /** @var array */
    protected array $unregister = [];

    /**
      * Instanciate the first time
      * ===================================================================================================
      *  @inheritdoc
      * @param string $id
      * @param Closure $concrete
      * @return void
      */
    public function set(string $id, Closure $concrete = null): void
    {
        if ($concrete === null) {
            $concrete = $id;
        }
        $this->instance[$id] = $concrete;
    }

    /**
    * @inheritdoc
    * ===================================================================================================
    * @param string $id Identifier of the entry to look for.
    * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
    * @throws ContainerExceptionInterface Error while retrieving the entry.
    * @return mixed Entry.
    */
    public function get(string $id, array $args = [])
    {
        if (!$this->has($id)) {
            $this->set($id);
        }
        $concrete = $this->instance[$id];
        return $this->resolved($concrete, $args);
    }

    /**
     * @inheritdoc
     *  ===================================================================================================
     * @param string $id Identifier of the entry to look for.
     * @return bool
     */
    public function has(string $id): bool
    {
        return isset($this->instance[$id]);
    }

    /**
       * Resolves a single dependency
       * ===================================================================================================
       * @param string $concrete
       * @return mixed|Object
       * @throws ContainerException
       * @throws DependencyIsNotInstantiableException
       * @throws DependencyHasNoDefaultValueException
       */
    protected function resolved($concrete, $args = [])
    {
        //Check if class exits
        if (!class_exists($concrete)) {
            throw new Exception("{$concrete} does not exist!");
        }
        //check if instance exist
        if ($concrete instanceof Closure) {
            return $concrete($this);
        }

        $reflection = new ReflectionClass($concrete);
        /* Check to see whether the class is instantiable */
        if (!$reflection->isInstantiable()) {
            throw new DependencyIsNotInstantiableException("Class {$concrete} is not instantiable.");
        }
        if ($resp = $reflection->hasProperty('container')) {
            $reflection->setStaticPropertyValue('container', $this);
        };
        /* Get the class constructor */
        $constructor = $reflection->getConstructor();
        if (is_null($constructor)) {
            /* Return the new instance */
            return $reflection->newInstance();
        }
        /* Get the constructor parameters */
        $parameters = $constructor->getParameters();
        $dependencies = $this->getDependencies($parameters, $reflection, $args);
        /* Get the new instance with dependency resolved */
        return $reflection->newInstanceArgs((array)$dependencies);
    }

    /**
        * Resolves all the dependencies
        * ===================================================================================================
        * @param ReflectionParameter $parameters
        * @param ReflectionClass $reflection
        * @return void
        */
    protected function getDependencies($parameters, ReflectionClass $reflection, array $args) :array
    {
        $dependencies = [];
        foreach ($parameters as $parameter) {
            $name = $parameter->getName();
            if (isset($args[$name])) {
                $dependency = $args[$name];
            } else {
                $dependency = $parameter->getClass();
                // $dependency = new ReflectionClass($parameter->getType()->getName());
            }
            if (is_null($dependency)) {
                if ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    throw new DependencyHasNoDefaultValueException('Sorry cannot resolve class dependency ' . $parameter->name);
                }
            } elseif (!$reflection->isUserDefined()) {
                $this->set($dependency->name);
            } else {
                if (is_object($dependency) && !in_array($dependency::class, ['Container', 'DatabaseConnexion', 'DataMapper', 'QueryBuilder', 'Crud', 'EntityManager']) && $name != 'model') {
                    $dependencies[] = $this->get($dependency->getName());
                } else {
                    $dependencies[] = $dependency;
                }
            }
        }

        return $dependencies;
    }

    /**
     * @inheritdoc
     *  ===================================================================================================
     * @param array $services
     * @return self
     */
    public function SetServices(array $services = []): self
    {
        if ($services) {
            $this->services = $services;
        }

        return $this;
    }

    /**
     * @inheritdoc
     *  ===================================================================================================
     * @return array
     */
    public function getServices(): array
    {
        return $this->services;
    }

    /**
     * @inheritdoc
     *  ===================================================================================================
     * @param array $args
     * @return self
     */
    public function unregister(array $args = []): self
    {
        $this->unregister = $args;
        return $this;
    }

    /**
     * Load container Models
     * ===================================================================================================
     * @param array $args
     * @return stdClass
     */
    public function load(array $args = []) : stdClass
    {
        if (is_array($args) && !empty($args)) {
            $is = new stdClass();
            foreach ($args as $class => $arg) {
                $str = explode('Manager', $class)[0];
                $is->$str = $this->get($class, $arg);
            }
            return $is;
        }
        return false;
    }
}