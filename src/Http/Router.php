<?php
/**
 * Class Router
 *
 * Simple router for handling routes.
 */

namespace DevinciIT\Modulr\Http;

class Router
{
    /**
     * @var array
     */
    protected array $routes = [];

    /**
     * Register a route.
     *
     * @param string $path
     * @param callable $handler
     * @return void
     */
    public function add(string $path, callable $handler): void
    {
        $this->routes[$path] = $handler;
    }

    /**
     * Dispatch the route.
     *
     * @param string $path
     * @return mixed|null
     */
    public function dispatch(string $path)
    {
        if (isset($this->routes[$path])) {
            return call_user_func($this->routes[$path]);
        }
        return null;
    }
}
