<?php
/**
 * Class Config
 *
 * Handles application configuration.
 */
namespace DevinciIT\Modulr\Core;

class Config
{
    /**
     * @var array
     */
    protected array $settings = [];

    /**
     * Set a configuration value.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, $value): void
    {
        $this->settings[$key] = $value;
    }

    /**
     * Get a configuration value.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $this->settings[$key] ?? $default;
    }
}
