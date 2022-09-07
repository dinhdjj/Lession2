<?php

namespace App\Core;

use App\Core\Exceptions\NotFoundException;
use App\Core\Interfaces\Application as IApplication;
use App\Core\Interfaces\Response as IResponse;
use App\Core\Interfaces\Router as IRouter;

class Router implements IRouter
{
    protected array $routes = [];

    public function get(string $path, string|callable|array $action): void
    {
        $this->routes['GET'][$path] = $action;
    }

    public function post(string $path, string|callable|array $action): void
    {
        $this->routes['POST'][$path] = $action;
    }

    public function resolve(IApplication $app): IResponse
    {
        $path = $app->request()->Uri();
        $method = $app->request()->method();
        $action = $this->routes[$method][$path] ?? null;

        if ($action === null) {
            throw new NotFoundException();
        }

        if (is_string($action)) {
            $action = [$action, '__invoke'];
        }

        if (is_array($action)) {
            $action[0] = new $action[0]();
        }

        return call_user_func($action, $app);
    }
}
