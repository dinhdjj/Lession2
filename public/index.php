<?php

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

echo 'Hello World!';
