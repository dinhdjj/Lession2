<?php

namespace App\Core\Interfaces;

interface Router
{
    /** Register a get route */
    public function get(string $path, string|callable|array $controller);

    /** Register a post route */
    public function post(string $path, string|callable|array $controller);

    /** Resolve route */
    public function resolve(Application $app): Response;
}
