<?php

namespace App\Core\Interfaces;

use PDO;

interface Database
{
    /** Boot database connection */
    public static function boot(Application $application): void;

    /** Get connection */
    public static function connection(): PDO;

    /** Insert data */
    public static function insert(string $statement, array $data = []): bool;

    /** Select data */
    public static function select(string $statement, array $data = []): array;

    /** Update data */
    public static function update(string $statement, array $data = []): bool;

    /** Delete data */
    public static function delete(string $statement, array $data = []): bool;
}
