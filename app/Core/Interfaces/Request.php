<?php

namespace App\Core\Interfaces;

interface Request
{
    /** Get input value */
    public function input(string $key, mixed $default = null): mixed;

    /** Get current method */
    public function method(): string;

    /** Get current uri */
    public function Uri(): string;
}
