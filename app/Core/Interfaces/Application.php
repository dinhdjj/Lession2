<?php

namespace App\Core\Interfaces;

interface Application
{
    /** Get current instance of request */
    public function request(): Request;

    /** Get root path */
    public function rootPath(): string;

    /** Get application config */
    public function config(string $key, mixed $default = null): mixed;

    /** Run application */
    public function run(): void;
}
