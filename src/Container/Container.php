<?php

namespace DevinciIT\Modulr\Container;

class Container
{
    protected array $bindings = [];
    protected array $instances = [];

    /**
     * Bind a class or interface
     */
    public function bind(string $abstract, callable $resolver): void
    {
        $this->bindings[$abstract] = $resolver;
    }

    /**
     * Register a singleton
     */
    public function singleton(string $abstract, callable $resolver): void
    {
        $this->bindings[$abstract] = function ($container) use ($resolver, $abstract) {
            if (!isset($this->instances[$abstract])) {
                $this->instances[$abstract] = $resolver($container);
            }
            return $this->instances[$abstract];
        };
    }

    /**
     * Resolve a class
     */
    public function make(string $abstract)
    {
        // If already instantiated
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        // If bound
        if (isset($this->bindings[$abstract])) {
            return $this->bindings[$abstract]($this);
        }

        // Auto-resolve (reflection)
        return $this->build($abstract);
    }

    /**
     * Build class with dependencies
     */
    protected function build(string $class)
    {
        $reflector = new \ReflectionClass($class);

        if (!$reflector->isInstantiable()) {
            throw new \Exception("Class {$class} is not instantiable");
        }

        $constructor = $reflector->getConstructor();

        if (!$constructor) {
            return new $class;
        }

        $dependencies = [];

        foreach ($constructor->getParameters() as $param) {
            $type = $param->getType();

            if ($type && !$type->isBuiltin()) {
                $dependencies[] = $this->make($type->getName());
            } else {
                throw new \Exception("Cannot resolve dependency {$param->getName()}");
            }
        }

        return $reflector->newInstanceArgs($dependencies);
    }
}