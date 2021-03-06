<?php
declare(strict_types=1);

class Container implements ContainerInterface
{
    /** @var static */
    protected static Application $instance;

    /** @var array[] */
    protected array $bindings = [];

    /** @var object[] */
    protected array $instances = [];
    /**
     * All of the registered rebound callbacks.
     *
     * @var array[]
     */
    protected $reboundCallbacks = [];

    public function __construct()
    {
    }

    /**
     * Set the shared instance of the container.
     *
     * @param  Container|null  $container
     * @return Container|static
     */
    public static function setInstance(ContainerInterface $container = null)
    {
        return static::$instance = $container;
    }

    /**
      * Get container instance
      * ====================================================================================================
      * @return static
      */
    public static function getInstance(): static
    {
        if (!isset(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Check is Container as singleton
     *  ===================================================================================================
     * @param string $id Identifier of the entry to look for.
     * @return bool
     */
    public function has(string $id): bool
    {
        return isset($this->instances[$id]);
    }

    public function bind(string $abstract, Closure | string | null $concrete = null, bool $shared = false): self
    {
        $this->bindings[$abstract] = [
            'concrete' => $concrete,
            'shared' => $shared,
        ];
        return $this;
    }

    public function singleton(string $abstract, Closure | string | null $concrete = null): self
    {
        return $this->bind($abstract, $concrete, true);
    }

    /**
     * Register an existing instance as shared in the container.
     *
     * @param  string  $abstract
     * @param  mixed  $instance
     * @return mixed
     */
    public function instance(string $abstract, mixed $instance) : mixed
    {
        $isBound = $this->bound($abstract);
        $this->instances[$abstract] = $instance;

        if ($isBound) {
            $this->rebound($abstract);
        }
        return $instance;
    }

    /**
     * Fire the "rebound" callbacks for the given abstract type.
     *
     * @param  string  $abstract
     * @return void
     */
    protected function rebound($abstract)
    {
        $instance = $this->make($abstract);

        foreach ($this->getReboundCallbacks($abstract) as $callback) {
            call_user_func($callback, $this, $instance);
        }
    }

    /**
        * Get the rebound callbacks for a given type.
        *
        * @param  string  $abstract
        * @return array
        */
    protected function getReboundCallbacks($abstract)
    {
        return $this->reboundCallbacks[$abstract] ?? [];
    }

    /**
     * Determine if the given abstract type has been bound.
     *
     * @param  string  $abstract
     * @return bool
     */
    public function bound($abstract)
    {
        return isset($this->bindings[$abstract]) ||
               isset($this->instances[$abstract]);
    }

    // public function instance(string $abstract, mixed $instans): void
    // {
    //     $this->instances[$abstract] = $instans;
    // }

    public function make(string $abstract): mixed
    {
        // 1. If the type has already been resolved as a singleton, just return it
        if ($this->has($abstract)) {
            return $this->instances[$abstract];
        }

        // 2. Get the registered concrete resolver for this type, otherwise we'll assume we were passed a concretion that we can instantiate
        $concrete = $this->bindings[$abstract]['concrete'] ?? $abstract;

        // 3. If the concrete is either a closure, or we didn't get a resolver, then we'll try to instantiate it.
        if ($concrete instanceof Closure || $concrete === $abstract) {
            $object = $this->build($concrete);
        }

        // 4. Otherwise the concrete must be referencing something else so we'll recursively resolve it until we get either a singleton instance, a closure, or run out of references and will have to try instantiating it.
        else {
            $object = $this->make($concrete);
        }

        // 5. If the class was registered as a singleton, we will hold the instance so we can always return it.
        if (isset($this->bindings[$abstract]) && $this->bindings[$abstract]['shared']) {
            $this->instances[$abstract] = $object;
        }

        return $object;
    }

    public function build(Closure | string $concrete): mixed
    {
        if ($concrete instanceof Closure) {
            return $concrete($this);
        }

        try {
            $reflector = new ReflectionClass($concrete);
        } catch (ReflectionException $e) {
            throw new BindingResolutionException("Target class [$concrete] does not exist.", 0, $e);
        }

        if (!$reflector->isInstantiable()) {
            throw new BindingResolutionException("Target [$concrete] is not instantiable.");
        }

        $constructor = $reflector->getConstructor();

        if ($constructor === null) {
            $obj = $reflector->newInstance();
            return $this->objectWithContainer($reflector, $obj);
        }

        $dependencies = $constructor->getParameters();
        $instances = $this->resolveDependencies($dependencies);
        $obj = $reflector->newInstanceArgs($instances);

        return $this->objectWithContainer($reflector, $obj);
    }

    protected function objectWithContainer(ReflectionClass $reflector, Object $obj)
    {
        if ($reflector->hasProperty('container')) {
            $reflectionContainer = $reflector->getProperty('container');
            $reflectionContainer->setAccessible(true);
            if (!$reflectionContainer->isInitialized($obj)) {
                $reflectionContainer->setValue($obj, $this);
            }
        }
        return $obj;
    }

    protected function resolveDependencies(array $dependencies): array
    {
        $results = [];

        foreach ($dependencies as $dependency) {
            // This is a much simpler version of what Laravel does

            $type = $dependency->getType(); // ReflectionType|null

            if (!$type instanceof ReflectionNamedType || $type->isBuiltin()) {
                throw new BindingResolutionException("Unresolvable dependency resolving [$dependency] in class {$dependency->getDeclaringClass()->getName()}");
            }

            $results[] = $this->make($type->getName());
        }

        return $results;
    }

    public function flush(): void
    {
        $this->bindings = [];
        $this->instances = [];
    }

    public function getRooter()
    {
        return $this->rooter;
    }
}