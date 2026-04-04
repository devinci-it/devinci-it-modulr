<?php

use DevinciIT\Modulr\Assets\AssetManager;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/helpers.php';

/*
|--------------------------------------------------------------------------
| Register Core Services
|--------------------------------------------------------------------------
*/

app()->singleton(AssetManager::class, function () {
    return new AssetManager();
});

/*
|--------------------------------------------------------------------------
| Initialize Request State
|--------------------------------------------------------------------------
|
| Ensure fresh asset state per request
|
*/

$am = app(AssetManager::class);
if (method_exists($am, 'reset')) {
    $am->reset();
}

/*
|--------------------------------------------------------------------------
| Future Services
|--------------------------------------------------------------------------
*/

return app();