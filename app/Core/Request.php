<?php

namespace App\Core;

use App\Core\Interfaces\Request as IRequest;

class Request implements IRequest
{
    public function __construct(
        protected array $get = [],
        protected array $post = [],
        protected array $server = [],
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function input(string $key, mixed $default = null): mixed
    {
        return $this->post[$key] ?? $this->get[$key] ?? $default;
    }

    /**
     * {@inheritDoc}
     */
    public function method(): string
    {
        return $this->server['REQUEST_METHOD'];
    }

    /**
     * {@inheritDoc}
     */
    public function Uri(): string
    {
        return $this->server['SCRIPT_NAME'];
    }
}
