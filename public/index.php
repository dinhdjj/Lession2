<?php

use App\Core\Application;
use App\Core\Request;

$root = dirname(__DIR__);

$config = require_once $root.'/config.php';

/**
 * Handle auto-loading of classes
 * Register app folder as App namespace
 */
spl_autoload_register(function ($class) use ($root): void {
    $file = str_replace('\\', '/', $class);
    $file = ltrim($file, 'App/').'.php';
    require_once $root.'/app/'.$file;
});

/**
 * Load helper
 */
require_once $root.'/helpers.php';

/**
 * Register and run application
 */
$router = require_once $root.'/routes.php';

$request = new Request($_GET, $_POST, $_SERVER);

$app = new Application(config: $config, root: $root, router: $router, request: $request);

define('APP', $app);

$app->run();
