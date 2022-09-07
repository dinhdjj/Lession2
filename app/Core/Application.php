<?php

namespace App\Core;

use App\Core\Exceptions\NotFoundException;
use App\Core\Interfaces\Application as IApplication;
use Exception;

class Application implements IApplication
{
    public function __construct(
        protected Request $request,
        protected Router $router,
        protected array $config,
        protected string $root,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function request(): Request
    {
        return $this->request;
    }

    /**
     * {@inheritDoc}
     */
    public function rootPath(): string
    {
        return $this->root;
    }

    /**
     * {@inheritDoc}
     */
    public function config(string $key, mixed $default = null): mixed
    {
        return $this->config[$key] ?? $default;
    }

    /**
     * {@inheritDoc}
     */
    public function run(): void
    {
        try {
            echo $this->router->resolve($this)->toHtml($this);
        } catch(NotFoundException $e) {
            echo (new View('errors.404', ['exception' => $e]))->toHtml($this);
        } catch (Exception $e) {
            echo (new View('errors.500', ['exception' => $e]))->toHtml($this);
        }
    }
}
