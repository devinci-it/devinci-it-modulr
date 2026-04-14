<?php
/**
 * Class ServiceContainer
 *
 * Simple service container for dependency management.
 */

namespace DevinciIT\Modulr\Container;

class ServiceContainer
{
    /**
     * @var array
     */
    protected array $services = [];

    /**
     * Register a service.
     *
     * @param string $name
     * @param mixed $service
     * @return void
     */
    public function set(string $name, $service): void
    {
        $this->services[$name] = $service;
    }

    /**
     * Get a service.
     *
     * @param string $name
     * @return mixed|null
     */
    public function get(string $name)
    {
        return $this->services[$name] ?? null;
    }
}
