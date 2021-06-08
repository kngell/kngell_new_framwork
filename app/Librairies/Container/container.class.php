<?php
declare(strict_types=1);
/**
 * Describes the interface of a container that exposes methods to read its entries.
 */
class Container implements ContainerInterface
{
    private array $instance = [];

    public function set($id = null, $concrete = null)
    {
        if ($concrete == null) {
            $concrete = $id;
        }
        $this->instance[$id] = $concrete;
    }

    public function get($id)
    {
        if (!$this->has($id)) {
            $this->set($id);
        }
        $concrete = $this->instance[$id] ;
        return $this->resolve($concrete);
    }

    public function has($id)
    {
        return isset($this->instance[$id]);
    }

    private function resolve($concrete)
    {
        $reflection = new ReflectionClass($concrete);
        if (!$reflection->isInstantiable()) {
            throw new DependencyIsNoInstanciateException('Class ' . $concrete . ' is not Instanciable');
        }
        $constructor = $reflection->getConstructor();
        if (is_null($constructor)) {
            return $reflection->newInstance();
        }
        $parameters = $constructor->getParameters();
        $dependencies = $this->getDependencies($parameters, $reflection);
        return $reflection->newInstanceArgs($dependencies);
    }

    private function getDependencies($parameters, $reflection)
    {
        $dependencies = [];
        foreach ($parameters as $parameter) {
            $dependency = $parameter->getClass();
            // $dependency = $parameter->getType() && !$parameter->getType()->isBuiltin() ? new ReflectionClass($parameter->getType()->getName()) : null;
            if (is_null($dependency)) {
                if ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    throw new DependencyHasNoDefaultValueException('Sorry! Cannot resolve class dependency : ' . $parameter->name);
                }
            } else {
                $dependencies[] = $this->get($dependency->name);
            }
        }
        return $dependencies;
    }
}