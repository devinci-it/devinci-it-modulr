<?php

use DevinciIT\Modulr\Container\Container;

if (!function_exists('app')) {
    function app(?string $abstract = null): mixed
    {
        static $container = null;

        if ($container === null) {
            $container = new Container();
        }

        return $abstract ? $container->make($abstract) : $container;
    }
}