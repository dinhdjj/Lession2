<?php

use App\Controllers\CategoryController;
use App\Core\Router;

$router = new Router();

$router->get('/', [CategoryController::class, 'index']);
$router->post('/store', [CategoryController::class, 'store']);
$router->post('/update', [CategoryController::class, 'update']);
$router->post('/delete', [CategoryController::class, 'delete']);

return $router;
