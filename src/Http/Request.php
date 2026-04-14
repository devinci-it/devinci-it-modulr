<?php
/**
 * Class Request
 *
 * Represents an HTTP request.
 */
namespace DevinciIT\Modulr\Http;

class Request
{
    /**
     * Get a value from the GET parameters.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $_GET[$key] ?? $default;
    }

    /**
     * Get a value from the POST parameters.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function post(string $key, $default = null)
    {
        return $_POST[$key] ?? $default;
    }
}
