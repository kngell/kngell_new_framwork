<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

/**
 * Describes the interface of a container that exposes methods to read its entries.
 */
class Container extends TestCase implements ContainerInterface
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
      *Instanciate the first time
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
    * @param string $id Identifier of the entry to look for.
    * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
    * @throws ContainerExceptionInterface Error while retrieving the entry.
    * @return mixed Entry.
    */
    public function get(string $id)
    {
        if (!$this->has($id)) {
            $this->set($id);
        }
        $concrete = $this->instance[$id];
        return $this->resolved($concrete);
    }

    /**
     * @inheritdoc
     * @param string $id Identifier of the entry to look for.
     * @return bool
     */
    public function has(string $id): bool
    {
        return isset($this->instance[$id]);
    }

    /**
       * Resolves a single dependency
       *
       * @param string $concrete
       * @return mixed|Object
       * @throws ContainerException
       * @throws DependencyIsNotInstantiableException
       * @throws DependencyHasNoDefaultValueException
       */
    protected function resolved($concrete)
    {
        if ($concrete instanceof Closure) {
            return $concrete($this);
        }

        $reflection = new ReflectionClass($concrete);
        /* Check to see whether the class is instantiable */
        if (!$reflection->isInstantiable()) {
            throw new DependencyIsNotInstantiableException("Class {$concrete} is not instantiable.");
        }

        /* Get the class constructor */
        $constructor = $reflection->getConstructor();
        if (is_null($constructor)) {
            /* Return the new instance */
            return $reflection->newInstance();
        }
        /* Get the constructor parameters */
        $parameters = $constructor->getParameters();
        $dependencies = $this->getDependencies($parameters, $reflection);
        /* Get the new instance with dependency resolved */
        return $reflection->newInstanceArgs((array)$dependencies);
    }

    /**
        * Resolves all the dependencies
        *
        * @param ReflectionParameter $parameters
        * @param ReflectionClass $reflection
        * @return void
        */
    protected function getDependencies($parameters, ReflectionClass $reflection)
    {
        $dependencies = [];
        foreach ($parameters as $parameter) {
            // $dependency = $parameter->getClass();
            $dependency = $parameter->getType() && !$parameter->getType()->isBuiltin() ? $reflection($parameter->getType()->getName()) : null;
            if (is_null($dependency)) {
                if ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    throw new DependencyHasNoDefaultValueException('Sorry cannot resolve class dependency ' . $parameter->name);
                }
            } elseif (!$reflection->isUserDefined()) {
                $this->set($dependency->name);
            } else {
                $dependencies[] = $this->get($dependency->name);
            }
        }

        return $dependencies;
    }

    /**
     * @inheritdoc
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
     * @return array
     */
    public function getServices(): array
    {
        return $this->services;
    }

    /**
     * @inheritdoc
     * @param array $args
     * @return self
     */
    public function unregister(array $args = []): self
    {
        $this->unregister = $args;
        return $this;
    }
}